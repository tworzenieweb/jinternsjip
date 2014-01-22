var Programs;

(function($) {
    
    Programs = {
        
        wrapper: null,
        maxHeight: null,
        
        init: function() {
            
            this.wrapper = $('footer .mcm_posts');
            
            this.initEvents();
            
        },
        initEvents: function() {
   
            $(window).on('resize', $.proxy(this.resizeEvent, this));
            
            $(".list-wrapper", this.wraper).smoothDivScroll({
                mousewheelScrolling: "allDirections",
                manualContinuousScrolling: false
            });
            
        },
        resizeEvent: function() {
                
            var equalElements = $('.body p', this.wrapper);
                
            if($(window).height() >= 769) {
                equalElements.removeAttr('style');
                equalElements.equalHeights();
            }
            else {
                equalElements.removeAttr('style');
            }
            
        }
        
    };
    
})(jQuery);