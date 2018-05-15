jQuery(document).ready(function(){
    function  nav_color(){
        jQuery('.field-color').each(function(){
            var p = jQuery(this); 
                 jQuery('.color',p).ColorPicker({
                    onSubmit: function(hsb, hex, rgb, el) {
                        jQuery(el).val(hex);
                        jQuery(el).ColorPickerHide();
                        jQuery(el).css('backgroundColor', '#' + hex);
                        return false;
                     },
                    onChange: function (hsb, hex, rgb, el) {
                        jQuery(el).val(hex);
                        jQuery('.color',p).css('backgroundColor', '#' + hex);
                    },
                    onBeforeShow: function () {
                        // var p = jQuery(this).parents('.field-color ');
                        jQuery(this).ColorPickerSetColor(this.value);
                    }
             }).bind('keyup', function(){
                   jQuery(this).ColorPickerSetColor(this.value);
                  jQuery(this).css('backgroundColor', '#' + this.value);
            }); 
            
        });
        
    
    }
      nav_color();
      // live change
      jQuery('#menu-to-edit').each(function(){
         var container = document.getElementById ("menu-to-edit");
         if(container.addEventListener){
             container.addEventListener ('DOMNodeInserted', nav_color, false);
         }
      });  
        
        
      
});