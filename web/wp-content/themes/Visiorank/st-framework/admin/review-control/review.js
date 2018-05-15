jQuery(document).ready(function(){
    
    jQuery('.ratting_criteria .list_item').sortable({
            handle : '.handle',
            stop: function(event,ui){
            }
    });
    /*
    jQuery('.ratting_criteria .ritem .jrating').raty({
            score    : 20,
            number:   20,
            cancel      : true,
            path : STreview_options.path,
            click       : function(score, evt) {
                var  p=  jQuery(this).parents('.ritem');
                jQuery('.score',p).val(score);
            }
    });
    */
    function addSliderToRate(p){
        var score = jQuery('input.score',p).val();
          var s =  jQuery('.sider',p).slider({
            min: 0,
            max: 100,
            range: "min",
            value: score,
            slide: function( event, ui ) {
              var  p=  jQuery(this).parents('.ritem');
                    jQuery('.score',p).val(ui.value);
            }
        });
        
         jQuery('input.score',p).keyup(function() {
            
            var sc = jQuery('input.score',p).val();
            sc = parseInt(sc);
            if(isNaN(sc)){
                sc=0;
            }
            if(sc>100){
                sc=100;
               
            }
            if(sc<0){
                sc=0;
            }
            
             //jQuery('input.score',p).val(sc);
             s.slider( "value",sc );
            // return false;
         });
        
    }
    
    jQuery('.ratting_criteria .list_item .ritem').each(function(){
        var  p = jQuery(this); 
        addSliderToRate(p);
    });
    
        
    
    jQuery('.ratting_criteria .add_more_r').live('click',function(){
        var  p = jQuery(this).parents('.ratting_criteria');
        /*
        var html = jQuery('.tpl_rate',p).html();
        
         jQuery('.list_item',p).append(html);
         var c = jQuery('.ritem',html);
         */
         
         var e = jQuery('.tpl_rate .ritem',p).clone();
        var c = e.appendTo(jQuery('.list_item',p));
         
         addSliderToRate(c);
         return false;
    });
    
    jQuery('.ratting_criteria .list_item div .remove').live('click',function(){
          var  p = jQuery(this).parents('.ratting_criteria .list_item div');
          p.remove();
         return false;
    });
    
    
});