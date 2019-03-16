<?php
namespace WScore\Html\WScore\Html;

/**
 *
 * @method a()
 * @method href()
 * @method target()
 * @method div()
 * @method input()
 * @method value()
 * @method required()
 * @method p()
 * @method bold()
 * @method i()
 * @method em()
 * @method option()
 * @method checked
 * @method optgroup
 * @method label
 * @method ul
 * @method nl
 * @method li
 * @method table
 * @method tr
 * @method th
 * @method td
 * @method span
 * @method dl
 * @method dd
 * @method dt
 * @method h1
 * @method h2
 * @method h3
 * @method h4
 * @method form
 * @method action
 * @method method
 * @method strong
 *
 * @cacheable
 */
class Tags
{
    /**
     * @Inject
     * @var \WScore\Html\ToHtml
     */
    public $_toString;

    /**
     * @Inject
     * @var \WScore\Html\Utils
     */
    public $utils;

    /** @var null                  name of tag, such as span */
    public $tagName    = null;

    /** @var array                 array of contents         */
    public $contents   = array();

    /** @var array                 array of attributes       */
    public $_attributes = array();

    /** @var bool                   true for tags such as <img /> */
    public $_noBodyTag = false;
    // +----------------------------------------------------------------------+
    //  constructions and static methods
    // +----------------------------------------------------------------------+
    /**
     * Start Tag object, with or without tag name.
     *
     * @param null $tagName
     * @param null $contents
     * @return Tags
     */
    public function __invoke( $tagName=null, $contents=null ) {
        return $this->_new( $tagName, $contents );
    }

    /**
     * construction of Tag object.
     *
     * @param ToHtml $toString
     * @param Utils $utils
     * @return \WScore\Html\Tags
     */
    public function __construct( $toString=null, $utils=null )
    {
        if( isset( $toString ) ) $this->_toString = $toString;
        if( isset( $utils ) ) $this->utils = $utils;
    }

    /**
     * @param string|null  $tagName
     * @param null|string $contents
     * @return \WScore\Html\Tags
     */
    public function _new( $tagName=null, $contents=null )
    {
        $class = get_called_class();
        /** @var $tags \WScore\Html\Tags */
        $tags = new $class( $this->_toString, $this->utils );
        $tags->_setTagName( $tagName );
        $tags->_setContents( $contents );
        return $tags;
    }

    /**
     * set attribute, or tagName if tagName is not set.
     *
     * @param string $name
     * @param array  $args
     * @return Tags
     */
    public function __call( $name, $args )
    {
        // attribute or tag if not set.
        if( is_null( $this->tagName ) ) { // set it as a tag name
            return $this->_new( $name, $args );
        }
        else {
            $this->_setAttribute( $name, $args );
        }
        return $this;
    }

    /**
     * @param $name
     * @return Tags
     */
    public function __get( $name ) {
        if( is_null( $this->tagName ) ) {
            return $this->_new( $name );
        }
        $this->_setAttribute( $name, true );
        return $this;
    }

    /**
     * wrap value with closure. use this to avoid encoding attribute values.
     *
     * @param string $value
     * @return callable
     */
    public static function _wrap( $value ) {
        return function() use( $value ) { return $value; };
    }

    public function _isSpanTag() {
        return $this->utils->isSpanTag( $this->tagName );
    }

    public function _isNoBodyTag() {
        return $this->_noBodyTag;
    }
    // +----------------------------------------------------------------------+
    //  mostly internal functions
    // +----------------------------------------------------------------------+
    /**
     * set tag name.
     *
     * @param string $tagName
     * @return Tags
     */
    protected function _setTagName( $tagName )
    {
        if( empty( $tagName ) ) return $this;
        $this->tagName = $this->utils->normalizeTagName( $tagName );
        $this->_noBodyTag = $this->utils->isNoBodyTag( $this->tagName );
        return $this;
    }

    /**
     * set contents.
     *
     * @param string|array|Tags $contents
     * @return Tags
     */
    protected function _setContents( $contents ) {
        if( empty( $contents ) ) return $this;
        if( is_array( $contents ) ) {
            $this->contents = array_merge( $this->contents, $contents );
        }
        else {
            $this->contents[] = $contents;
        }
        return $this;
    }

    /**
     * @param array $attributes
     * @return \WScore\Html\Tags
     */
    public function _assignAttributes( $attributes )
    {
        if( empty( $attributes ) ) return $this;
        foreach( $attributes as $name => $value ) {
            $this->$name( $value );
        }
        return $this;
    }
    /**
     * set attribute. if connector is not set, attribute is replaced.
     *
     * @param string       $name
     * @param string|array $value
     * @param bool|string  $connector
     * @return Tags
     */
    public function _setAttribute( $name, $value, $connector=null )
    {
        if( is_array( $value ) && !empty( $value ) ) {
            foreach( $value as $val ) {
                $this->_setAttribute( $name, $val, $connector );
            }
            return $this;
        }
        elseif( is_array( $value ) ) {
            $value = '';
        }
        if( $value === false ) return $this;     // ignore the property.
        $name = $this->utils->normalize( $name );
        if( $value === true  ) $value = $name;   // same as name (checked="checked")
        // set connector if it is not set.
        if( $connector === null ) {
            $connector = $this->utils->getConnector( $name ); // default is to replace value.
        }
        // set attribute.
        if( !isset( $this->_attributes[ $name ] ) // new attribute.
            || $connector === false ) {          // replace with new value.
            $this->_attributes[ $name ] = $value;
        }
        else {                                   // attribute is appended.
            $this->_attributes[ $name ] .= $connector . $value;
        }
        return $this;
    }

    // +----------------------------------------------------------------------+
    //  methods for setting tags, attributes, and contents.
    // +----------------------------------------------------------------------+
    /**
     * set contents.
     *
     * @internal param array|string|Tags $contents
     * @return Tags
     */
    public function _contain()
    {
        /** @var $args array */
        $args = func_get_args();
        return $this->_setContents( $args );
    }

    /**
     * @param null|string $find
     * @return array|string|Tags
     */
    public function _get( $find=null )
    {
        if( is_null( $find ) ) {
            return $this->contents;
        }
        if( is_numeric( $find ) && array_key_exists( $find, $this->contents ) ) {
            return $this->contents[ $find ];
        }
        if( is_string( $find ) ) {
            // find tagName.
            foreach( $this->contents as $tag ) {
                if( $tag instanceof Tags && $tag->tagName === $find ) {
                    return $tag;
                }
            }
        }
        return array();
    }

    /**
     * set class name. adds to the existing class.
     *
     * @param string $class
     * @param string $connector    set FALSE to reset class.
     * @return Tags
     */
    public function class_( $class, $connector=' ' ) {
        return $this->_setAttribute( 'class', $class, $connector );
    }

    /**
     * set style. adds to the existing style.
     *
     * @param string $style
     * @param string $connector    set FALSE to reset style.
     * @return Tags
     */
    public function style( $style, $connector='; ' ) {
        return $this->_setAttribute( 'style', $style, $connector );
    }

    /**
     * @param \Closure $func
     * @param string $attribute
     */
    public function _walk( $func, $attribute=null )
    {
        if( !$attribute || isset( $this->$attribute ) || isset( $this->_attributes[ $attribute ] ) ) {
            $func( $this );
        }
        if( !empty( $this->contents ) ) {
            foreach( $this->contents as $content ) {
                if( $content instanceof self ) {
                    $content->_walk( $func, $attribute );
                }
            }
        }
    }
    // +----------------------------------------------------------------------+
    //  convert Tags to a string.
    // +----------------------------------------------------------------------+
    /**
     * @param string $head
     * @return string
     */
    public function _toString( $head='' )
    {
        return $this->_toString->toString( $this, $head );
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->_toString();
    }
    // +----------------------------------------------------------------------+
}