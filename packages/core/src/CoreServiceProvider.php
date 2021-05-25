<?php

namespace Mi\Core;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Mi\Core\Commands\MakeCollection;
use Mi\Core\Commands\MakeConcern;
use Mi\Core\Commands\MakeContract;
use Mi\Core\Commands\MakeCriteria;
use Mi\Core\Commands\MakeException;
use Mi\Core\Commands\MakeFilter;
use Mi\Core\Commands\MakeModel;
use Mi\Core\Commands\MakeRepository;
use Mi\Core\Commands\MakeRequest;
use Mi\Core\Commands\MakeService;
use Mi\Core\Commands\MakeTrait;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCollection::class,
                MakeConcern::class,
                MakeContract::class,
                MakeCriteria::class,
                MakeException::class,
                MakeFilter::class,
                MakeModel::class,
                MakeRepository::class,
                MakeRequest::class,
                MakeService::class,
                MakeTrait::class,
            ]);
        }

        $this->registerResponseMacros();
        $this->extendValidator();
        $this->extendOrderBy();
        $this->addEloquentMacros();
    }

    private function registerResponseMacros()
    {
        Response::macro('success', function ($data) {
            return response()->json($data, 200);
        });

        /**
         * Return a new JSON response with status code 200.
         *
         * @package \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
         * @param array  $data
         * @return \Illuminate\Http\JsonResponse
         */
        Response::macro('created', function ($data) {
            return response()->json($data, 201);
        });

        Response::macro('successWithoutData', function () {
            return response()->json([ 'success' => true ], 200);
        });

        Response::macro('notModified', function ($data) {
            return response()->json($data, 304);
        });

        Response::macro('error', function ($data, $statusCode = 400) {
            return response()->json($data, $statusCode);
        });

        Response::macro('notFound', function ($data) {
            return response()->json($data, 404);
        });

        Response::macro('invalid', function ($data) {
            return response()->json($data, 422);
        });
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function extendValidator()
    {
        Validator::extend('is_kana', function ($attribute, $value) {
            $regex = '{^(
                (\xe3\x82[\xa1-\xbf])
               |(\xe3\x83[\x80-\xbe])
               |(\xef\xbc[\x90-\x99])
               |(\xef\xbd[\xa6-\xbf])
               |(\xef\xbe[\x80-\x9f])
               |(\xe3\x80\x80)
            )+$}x';

            return preg_match($regex, $value) === 1 || is_null($value);
        });
    }

    private function extendOrderBy()
    {
        Builder::macro('newOrderByDesc', function ($column, $direction = 'asc') {
            if ($this->isQueryable($column)) {
                [$query, $bindings] = $this->createSub($column);

                $column = new Expression('('.$query.')');

                $this->addBinding($bindings, $this->unions ? 'unionOrder' : 'order');
            }

            $direction = strtolower($direction);

            if (! in_array($direction, ['asc', 'desc', 'desc nulls last'], true)) {
                throw new InvalidArgumentException('Order direction must be "asc" or "desc".');
            }

            $this->{$this->unions ? 'unionOrders' : 'orders'}[] = [
                'column' => $column,
                'direction' => $direction,
            ];

            return $this;
        });
    }

    /** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
    private function addEloquentMacros()
    {
        /**
         * Add a subselect exists to query.
         *
         * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
         * @param  string  $as
         * @return \Illuminate\Database\Query\Builder|static
         *
         * @throws \InvalidArgumentException
         */
        QueryBuilder::macro('selectExists', function ($query, $as) {
            [$query, $bindings] = $this->createSub($query);

            return $this->selectRaw(
                'exists(' . $query . ') as ' . $this->grammar->wrap($as),
                $bindings
            );
        });
    }
}
