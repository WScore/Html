<?php
namespace WScore\Html;

/**
 * Class ToHtml
 * @package WScore\Html
 *
 * @cacheable
 */
class ToHtml
{
    /**
     * create tag without content, such as <tag attributes... />
     *
     * @param Tags   $tags
     * @param string $head
     * @return string
     */
    public function toString( $tags, $head='' )
    {
        $html = $head;
        if( $tags->_isNoBodyTag() ) {
            $html .= $this->noBodyTag( $tags );
        }
        elseif( $tags->_isSpanTag() || count( $tags->contents ) == 1 ) {
            $html .= $this->oneContentTag( $tags );
        }
        else {
            $html .= $this->contentTag( $tags, $head );
        }
        if( !$tags->_isSpanTag() && !$tags->_isNoBodyTag() ) {
            // add new-line, except for in-line tags.
            $html .= "\n";
        }
        return $html;
    }

    /**
     * create tag without content, such as <tag attributes... />
     *
     * @param Tags $tags
     * @return string
     */
    private function noBodyTag( $tags )
    {
        $html = "<{$tags->tagName}" . $this->toAttribute( $tags ) . ' />';
        return $html;
    }

    /**
     * short tag such as <tag>only one content</tag>
     *
     * @param Tags $tags
     * @return string
     */
    private function oneContentTag( $tags )
    {
        $html  = "<{$tags->tagName}" . $this->toAttribute( $tags ) . ">";
        $html .= $this->toContents( $tags );
        $html .= "</{$tags->tagName}>";
        return $html;
    }

    /**
     * create tag with contents inside.
     *
     * @param Tags   $tags
     * @param string $head
     * @return string
     */
    private function contentTag( $tags, $head='' )
    {
        $html  = "<{$tags->tagName}" . $this->toAttribute( $tags ) . ">";
        $html .= "\n";
        $html .= $this->toContents( $tags, $head . '  ' );
        if( substr( $html, -1 ) != "\n" ) $html .= "\n";
        $html .= $head . "</{$tags->tagName}>";
        return $html;
    }
    /**
     * @param Tags   $tags
     * @param string $head
     * @return string
     */
    private function toContents( $tags, $head="" ) 
    {
        $html = '';
        if( empty( $tags->contents ) ) return $html;
        foreach( $tags->contents as $content ) {
            if( !$tags->_isNoBodyTag() && !Utils::isSpanTag( $tags->tagName ) && $html && substr( $html, -1 ) != "\n" ) {
                $html .= "\n";
            }
            if( is_object( $content ) && method_exists( $content, '_toString' ) ) {
                $html .= $content->_toString( $head );
            }
            else {
                $html .= $head . (string) $content;
            }
        }
        return $html;
    }

    /**
     * @param Tags    $tags
     * @return string
     */
    private function toAttribute( $tags ) 
    {
        $attr = '';
        if( !empty( $tags->_attributes ) )
            foreach( $tags->_attributes as $name => $value ) {
                if( $value instanceof \Closure ) {
                    $value = $value(); // wrapped by closure. use it as is.
                }
                else {
                    $value = Utils::_safe( $value ); // make it very safe.
                }
                $attr .= " {$name}=\"{$value}\"";
            }
        return $attr;
    }

}