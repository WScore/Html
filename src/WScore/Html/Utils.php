<?php
namespace WScore\Html\WScore\Html;

/**
 * Class Utils
 * @package WScore\Html
 *
 * @cacheable
 */
class Utils
{

    /** @var array                 normalize tag name  */
    public $_normalize_tag = array(
        'b'       => 'strong',
        'bold'    => 'strong',
        'italic'  => 'i',
        'image'   => 'img',
        'item'    => 'li',
        'order'   => 'ol',
        'number'  => 'nl',
    );

    /** @var array                  tags without contents */
    public $_tag_no_body = array(
        'br', 'img', 'input',
    );

    /** @var array                  in-line tags   */
    public $_tag_span = array(
        'span', 'p', 'strong', 'i', 'sub', 'li', 'a', 'label', 'textarea',
    );

    /** @var array                  how to connect attribute values */
    public $_attribute_connectors = array(
        'class' => ' ',
        'style' => '; ',
    );

    /** @var string                 encoding */
    public $_encoding = 'UTF-8';

    /**
     * @param string $tagName
     * @return bool
     */
    public function isSpanTag( $tagName ) {
        return in_array( $tagName, $this->_tag_span );
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function normalizeTagName( $tagName ) {
        $tagName = strtolower( $tagName );
        if( array_key_exists( $tagName, $this->_normalize_tag ) ) {
            $tagName = $this->_normalize_tag[ $tagName ];
        }
        return $tagName;
    }

    /**
     * @param $tagName
     * @return bool
     */
    public function isNoBodyTag( $tagName ) {
        return in_array( $tagName, $this->_tag_no_body );
    }

    /**
     * @param $name
     * @return bool
     */
    public function getConnector( $name ) {
        $connector = false;
        if( array_key_exists( $name, $this->_attribute_connectors ) ) {
            $connector = $this->_attribute_connectors[ $name ];
        }
        return $connector;
    }

    /**
     * normalize tag and attribute name: lower case, and remove first _ if exists.
     *
     * @param string $name
     * @return string
     */
    public function normalize( $name ) {
        $name = strtolower( $name );
        if( $name[0]=='_' ) $name = substr( $name, 1 );
        if( substr( $name, -1 ) == '_' ) $name = substr( $name, 0, -1 );
        $name = str_replace( '_', '-', $name );
        return $name;
    }

    /**
     * make string VERY safe for html.
     *
     * @param string $value
     * @return string
     */
    public function _safe( $value ) {
        if( empty( $value ) ) return $value;
        return htmlentities( $value, ENT_QUOTES, $this->_encoding );
    }
}