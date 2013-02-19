<?php
namespace WScore\Html;

class Forms
{
    /**
     * @Inject
     * @var \WScore\Html\Elements
     */
    public $elements;

    /**
     * @param \WScore\Html\Elements $elements
     * @return \WScore\Html\Forms
     */
    public function __construct( $elements=null )
    {
        if( $elements ) $this->elements = $elements;
    }

    /**
     * for input elements: text, password, date, etc.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $attributes
     * @return \WScore\Html\Elements
     */
    public function input( $type, $name='', $value='', $attributes=array() )
    {
        /** @var $input Elements */
        $input = $this->elements->input->type( $type )->name( $name )->value( $value );
        if( !empty( $attributes ) ) $input->_assignAttributes( $attributes );
        return $input;
    }

    /**
     * @param string $method
     * @param array  $args
     * @return \WScore\Html\Elements
     */
    public function __call( $method, $args )
    {
        if( $method == 'check' ) $method = 'checkbox';
        $args = array_merge( array( $method ), $args );
        return call_user_func_array( array( $this, 'input' ), $args );
    }

    /**
     * @param string $name
     * @param string $value
     * @param array  $attributes
     * @return Elements
     */
    public function textArea( $name='', $value='', $attributes=array() )
    {
        /** @var $ta Elements */
        $ta = $this->elements->textarea( $value )->name( $name );
        $ta->_assignAttributes( $attributes );
        return $ta;
    }

    /**
     * @param string $name
     * @param array  $items
     * @param array  $checked
     * @param array  $attributes
     * @return Elements
     */
    public function select( $name, $items, $checked=array(), $attributes=array() )
    {
        /** @var $form Elements */
        $form = $this->elements->select->name( $name );
        $form->_assignAttributes( $attributes );
        $this->makeOptions( $form, $items, $checked );
        if( array_key_exists( 'multiple', $attributes ) ) $form->_setMultipleName();
        return $form;
    }

    /**
     * makes option list for Select box.
     *
     * @param Elements $select
     * @param array $items
     * @param array|string $checked
     * @return void
     */
    public function makeOptions( $select, $items, $checked )
    {
        if( $checked && !is_array( $checked ) ) $checked = array( $checked );
        $groupList = array();
        foreach( $items as $item )
        {
            $value = $item[0];
            $label = $item[1];
            $option = $select->_new()->option( $label )->value( $value );
            if( in_array( $value, $checked ) ) {
                /** @noinspection PhpUndefinedMethodInspection */
                $option->selected( true );
            }
            if( isset( $item[2] ) )
            {
                $group = $item[2];
                /** @var $optGroup Elements */
                if( array_key_exists( $group, $groupList ) ) {
                    $optGroup = $groupList[ $group ];
                }
                else {
                    $optGroup = $select->_new()->optgroup()->label( $group );
                    $select->_contain( $optGroup );
                    $groupList[ $group ] = $optGroup;
                }
                $optGroup->_contain( $option );
            }
            else {
                $select->_contain( $option );
            }
        }
    }
}
