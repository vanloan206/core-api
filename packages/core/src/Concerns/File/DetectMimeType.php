<?php

namespace Mi\Core\Concerns\File;

use Illuminate\Support\Str;

class DetectMimeType
{
    const DEFAULT_MIME_TYPE = 'application/octet-stream'; // general purpose MIME-type
    const MIME_TYPES = [
        'aac' => 'audio/aac', // AAC audio
        'abw' => 'application/x-abiword', // AbiWord document
        'arc' => 'application/octet-stream', // Archive document (multiple files embedded)
        'avi' => 'video/x-msvideo', // AVI: Audio Video Interleave
        'azw' => 'application/vnd.amazon.ebook', // Amazon Kindle eBook format
        'bin' => 'application/octet-stream', // Any kind of binary data
        'bmp' => 'image/bmp', // Windows OS/2 Bitmap Graphics
        'bz' => 'application/x-bzip', // BZip archive
        'bz2' => 'application/x-bzip2', // BZip2 archive
        'csh' => 'application/x-csh', // C-Shell script
        'css' => 'text/css', // Cascading Style Sheets (CSS)
        'csv' => 'text/csv', // Comma-separated values (CSV)
        'doc' => 'application/msword', // Microsoft Word
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Microsoft Word (OpenXML)
        'eot' => 'application/vnd.ms-fontobject', // MS Embedded OpenType fonts
        'epub' => 'application/epub+zip', // Electronic publication (EPUB)
        'gif' => 'image/gif', // Graphics Interchange Format (GIF)
        'htm' => 'text/html', // HyperText Markup Language (HTML)
        'html' => 'text/html', // HyperText Markup Language (HTML)
        'ico' => 'image/x-icon', // Icon format
        'ics' => 'text/calendar', // iCalendar format
        'jar' => 'application/java-archive', // Java Archive (JAR)
        'jpeg' => 'image/jpeg', // JPEG images
        'jpg' => 'image/jpeg', // JPEG images
        'js' => 'application/javascript', // JavaScript (IANA Specification) (RFC 4329 Section 8.2)
        'json' => 'application/json', // JSON format
        'mid' => 'audio/midi audio/x-midi', // Musical Instrument Digital Interface (MIDI)
        'midi' => 'audio/midi audio/x-midi', // Musical Instrument Digital Interface (MIDI)
        'mpeg' => 'video/mpeg', // MPEG Video
        'mpkg' => 'application/vnd.apple.installer+xml', // Apple Installer Package
        'odp' => 'application/vnd.oasis.opendocument.presentation', // OpenDocument presentation document
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet', // OpenDocument spreadsheet document
        'odt' => 'application/vnd.oasis.opendocument.text', // OpenDocument text document
        'oga' => 'audio/ogg', // OGG audio
        'ogv' => 'video/ogg', // OGG video
        'ogx' => 'application/ogg', // OGG
        'otf' => 'font/otf', // OpenType font
        'png' => 'image/png', // Portable Network Graphics
        'pdf' => 'application/pdf', // Adobe Portable Document Format (PDF)
        'ppt' => 'application/vnd.ms-powerpoint', // Microsoft PowerPoint
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation', // Microsoft PowerPoint (OpenXML)
        'rar' => 'application/x-rar-compressed', // RAR archive
        'rtf' => 'application/rtf', // Rich Text Format (RTF)
        'sh' => 'application/x-sh', // Bourne shell script
        'svg' => 'image/svg+xml', // Scalable Vector Graphics (SVG)
        'swf' => 'application/x-shockwave-flash', // Small web format (SWF) or Adobe Flash document
        'tar' => 'application/x-tar', // Tape Archive (TAR)
        'tif' => 'image/tiff', // Tagged Image File Format (TIFF)
        'tiff' => 'image/tiff', // Tagged Image File Format (TIFF)
        'ts' => 'application/typescript', // Typescript file
        'ttf' => 'font/ttf', // TrueType Font
        'txt' => 'text/plain', // Text, (generally ASCII or ISO 8859-n)
        'vsd' => 'application/vnd.visio', // Microsoft Visio
        'wav' => 'audio/wav', // Waveform Audio Format
        'weba' => 'audio/webm', // WEBM audio
        'webm' => 'video/webm', // WEBM video
        'webp' => 'image/webp', // WEBP image
        'woff' => 'font/woff', // Web Open Font Format (WOFF)
        'woff2' => 'font/woff2', // Web Open Font Format (WOFF)
        'xhtml' => 'application/xhtml+xml', // XHTML
        'xls' => 'application/vnd.ms-excel', // Microsoft Excel
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Microsoft Excel (OpenXML)
        'xml' => 'application/xml', // XML
        'xul' => 'application/vnd.mozilla.xul+xml', // XUL
        'zip' => 'application/zip', // ZIP archive
        '3gp' => 'video/3gpp', // 3GPP audio/video container
        '3g2' => 'video/3gpp2', // 3GPP2 audio/video container
        '7z' => 'application/x-7z-compressed', // 7-zip archive
    ];

    /**
     * Get mime type from file name
     *
     * @param string $name
     * @return string
     */
    public static function getMimeType(string $name)
    {
        $ext = Str::lower(pathinfo($name)['extension'] ?? $name);

        return self::MIME_TYPES[$ext] ?? self::DEFAULT_MIME_TYPE;
    }
}
