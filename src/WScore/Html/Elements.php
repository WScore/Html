<?php
namespace WScore\Html;

class Elements extends Tags
{
    /**
     * set http method for form element.
     *
     * @param $method
     * @return \WScore\Html\Elements
     */
    public function method( $method )
    {
        $method  = strtolower( $method );
        $_method = $method;
        if( $method !== 'get' ) {
            // for method other than get, set $method to 'post'.
            $method = 'post';
        }
        $this->_attributes[ 'method' ] = $method;
        if( $this->tagName == 'form' && $method !== $_method ) {
            // set hidden tag to overwrite the desired method.
            $this->_contain( $this->_new()->input->type( 'hidden' )->name( '_method' )->value( $_method ) );
        }
        return $this;
    }
    /**
     * makes the form object to array style name (i.e. name="varName[]").
     *
     * @return \WScore\Html\Elements
     */
    public function _setMultipleName()
    {
        $addMultiple = function( $form ) {
            /** @var $form Elements */
            if( isset( $form->_attributes[ 'name' ] ) ) { $form->_attributes[ 'name' ].= '[]'; }
        };
        /** @var $div Elements */
        $this->_walk( $addMultiple );
        return $this;
    }

    /**
     * @return \WScore\Html\Elements
     */
    public function _walkSetId()
    {
        $addId = function( $form ) {
            /** @var $form Elements */
            $form->_setId();
        };
        $this->_walk( $addId );
        return $this;
    }

    /**
     * set id attribute; id is generated from name if not set.
     *
     * @param string|null $id
     * @return \WScore\Html\Elements
     */
    public function _setId( $id=null ) {
        if( !$id ) {
            $id = array_key_exists( 'name', $this->_attributes ) ? $this->_attributes[ 'name' ] : false;
            if( $id === false ) return $this; // do not set id for tags without name attribute.
            $id = str_replace( array( '[', ']' ), '_', $id );
            // add value to id for checkbox and radio buttons to make a unique id.
            if( isset( $this->_attributes[ 'value' ] ) && isset( $this->_attributes[ 'type' ] ) ) {
                $type = strtolower( $this->_attributes[ 'type' ] );
                if( in_array( $type, array( 'checkbox', 'radio' ) ) ) {
                    $id .= '_' . $this->_attributes[ 'value' ];
                }
            }
        }
        $this->_setAttribute( 'id', $id );
        return $this;
    }
    /**
     * set up ime mode in style.
     *
     * @param $ime
     * @return \WScore\Html\Elements
     */
    public function ime( $ime ) {
        static $ime_style;
        if( !isset( $ime_style ) ) {
            $ime_style = array(
                'ON'  => 'ime-mode:active',
                'OFF' => 'ime-mode:inactive',
                'I1'  => 'istyle:1',
                'I2'  => 'istyle:2',
                'I3'  => 'istyle:3',
                'I4'  => 'istyle:4',
            );
        }
        if( isset( $ime_style[ strtoupper( $ime ) ] ) ) {
            $this->style( $ime_style[ strtoupper( $ime ) ] );
        }
        return $this;
    }
}