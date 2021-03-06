var Programs;

(function($) {
    
    Programs = {
        
        wrapper: null,
        maxHeight: null,
        
        init: function() {
            
            this.wrapper = $('footer .excerpt');
            
            this.initEvents();
            
        },
        initEvents: function() {
   
            $(window).on('resize', $.proxy(this.resizeEvent, this));
            
        },
        resizeEvent: function() {
                
            var equalElements = $('.body p', this.wrapper);
            var equalElements2 = $('.mcm_programs .inner', this.wrapper);
                
            if($(window).width() >= 769) {
                equalElements.removeAttr('style');
                equalElements.equalHeights();
                equalElements2.removeAttr('style');
                equalElements2.equalHeights();
                
                $("footer .excerpt .list-wrapper").smoothDivScroll({
                    mousewheelScrolling: "allDirections",
                    manualContinuousScrolling: false
                });
                
            }
            else {
                equalElements.removeAttr('style');
                equalElements2.removeAttr('style');
            }
            
        }
        
    };
    
})(jQuery);