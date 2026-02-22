<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if (!class_exists('DOMDocument')) {
    class DOMDocument
    {
        public $preserveWhiteSpace = true;
        public $formatOutput = false;
        public $documentElement;
        public function __construct()
        {
            $this->documentElement = new DOMElement();
        }
        public function loadHTML($source, $options = 0)
        {
            return true;
        }
        public function loadXML($source, $options = 0)
        {
            return true;
        }
        public function saveHTML($node = null)
        {
            return '';
        }
        public function saveXML($node = null)
        {
            return '';
        }
        public function getElementsByTagName($name)
        {
            return new DOMNodeList([new DOMElement()]);
        }
        public function createElement($name, $value = '')
        {
            return new DOMElement();
        }
        public function createTextNode($content)
        {
            return new DOMElement();
        }
        public function appendChild($node)
        {
            return $node;
        }
        public function importNode($node, $deep = false)
        {
            return $node;
        }
    }
    class DOMNode
    {
        public $nodeName = 'div';
        public $nodeValue = '';
        public $textContent = '';
        public $parentNode;
        public $childNodes;
        public $previousSibling = null;
        public $nextSibling = null;
        public $firstChild = null;
        public $lastChild = null;
        public function __construct()
        {
            $this->childNodes = new DOMNodeList();
        }
        public function appendChild($node)
        {
            return $node;
        }
        public function removeChild($node)
        {
            return $node;
        }
        public function hasChildNodes()
        {
            return false;
        }
    }
    class DOMElement extends DOMNode
    {
        public function setAttribute($name, $value)
        {
        }
        public function getAttribute($name)
        {
            return '';
        }
        public function hasAttribute($name)
        {
            return false;
        }
        public function appendChild($node)
        {
            return $node;
        }
    }
    class DOMNodeList implements Countable, IteratorAggregate
    {
        protected $items = [];
        public function __construct($items = [])
        {
            $this->items = $items;
        }
        public function count(): int
        {
            return count($this->items);
        }
        public function getIterator(): Traversable
        {
            return new ArrayIterator($this->items);
        }
        public function item($index)
        {
            return $this->items[$index] ?? null;
        }
    }
}

if (!function_exists('mb_split')) {
    function mb_split($pattern, $string, $limit = -1)
    {
        return preg_split('/' . $pattern . '/', $string, $limit);
    }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string, $encoding = null)
    {
        return strtolower($string);
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string, $encoding = null)
    {
        return strtoupper($string);
    }
}
if (!function_exists('mb_strlen')) {
    function mb_strlen($string, $encoding = null)
    {
        return strlen($string);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($string, $start, $length = null, $encoding = null)
    {
        return substr($string, $start, $length);
    }
}
if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack, $needle, $offset = 0, $encoding = null)
    {
        return strpos($haystack, $needle, $offset);
    }
}
if (!function_exists('mb_detect_encoding')) {
    function mb_detect_encoding($string, $encodings = null, $strict = false)
    {
        return 'UTF-8';
    }
}

if (!function_exists('mb_strwidth')) {
    function mb_strwidth($string)
    {
        return strlen($string);
    }
}
if (!function_exists('mb_strimwidth')) {
    function mb_strimwidth($string, $start, $width, $trimmarker = '', $encoding = null)
    {
        $str = substr($string, $start, $width);
        return $str . $trimmarker;
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
