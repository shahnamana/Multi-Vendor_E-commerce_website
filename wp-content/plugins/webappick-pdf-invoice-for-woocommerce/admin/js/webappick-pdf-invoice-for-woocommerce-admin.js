(function( $ ) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     */

    // scroll add and remove class
    $(window).scroll(function() {
        if ($(this).scrollTop() + $(window).height() < $(document).height()-150){
            $('.woo-invoice-save-changes-selector').addClass("woo-invoice-save-changes");
        }
        else{
            $('.woo-invoice-save-changes-selector').removeClass("woo-invoice-save-changes");
        }
    });

    $(window).on("mousewheel", function(e) {

        //if($(window).scrollTop() + $(window).height() > $(document).height()-100)  {

            //$(".woo-invoice-save-changes-selector").removeClass("woo-invoice-save-changes");
       // } else {
            //$(".woo-invoice-save-changes-selector").addClass("woo-invoice-save-changes");
        //}

        var initialContent = $( ".woo-invoice-dashboard-content > li:eq(0)" );
        $('.woo-invoice-dashboard-sidebar .woo-invoice-sidebar-navbar-light').height(initialContent.parent().height()-23);

    });

    $( window ).load(function() {

        // Order List Invoice Button Redirect
		$(".wpifw_invoice_action_button").click(function (event) {
            event.preventDefault();
        	var URL=$(this).attr('href');
            window.open(URL,'_blank');
            return false;
        });



		// Bulk PDF Invoice & Packing Slip action redirect
        $("#doaction, #doaction2").click(function (event) {
            var actionselected = $(this).attr("id").substr(2);
            var getAction = $('select[name="' + actionselected + '"]').val();
            if(getAction==="wpifw_bulk_invoice"){
            	event.preventDefault();
                var wpifwOrderIds = [];
                $('tbody th.check-column input[type="checkbox"]:checked').each(
                    function() {
                        wpifwOrderIds.push($(this).val());
                    }
                );

                if (!wpifwOrderIds.length) {
                    alert('You have to select orders first!');
                     return false;
                }

                var order_ids=wpifwOrderIds.join(',');
				var URL;
                if (wpifw_ajax_obj.wpifw_ajax_url.indexOf("?") != -1) {
                    URL = wpifw_ajax_obj.wpifw_ajax_url+'&action=wpifw_generate_invoice&order_ids='+order_ids+'&_wpnonce='+wpifw_ajax_obj.nonce;
                } else {
                    URL = wpifw_ajax_obj.wpifw_ajax_url+'?action=wpifw_generate_invoice&order_ids='+order_ids+'&_wpnonce='+wpifw_ajax_obj.nonce;
                }

                window.open(URL,'_blank');

                return false;
			}else if(getAction==="wpifw_bulk_invoice_packing_slip"){

                event.preventDefault();
                var wpifwOrderIds = [];
                $('tbody th.check-column input[type="checkbox"]:checked').each(
                    function() {
                        wpifwOrderIds.push($(this).val());
                    }
                );

                if (!wpifwOrderIds.length) {
                    alert('You have to select orders first!');
                    return false;
                }

                var order_ids=wpifwOrderIds.join(',');
                var URL;
                if (wpifw_ajax_obj.wpifw_ajax_url.indexOf("?") != -1) {
                    URL = wpifw_ajax_obj.wpifw_ajax_url+'&action=wpifw_generate_invoice_packing_slip&order_ids='+order_ids+'&_wpnonce='+wpifw_ajax_obj.nonce;
                } else {
                    URL = wpifw_ajax_obj.wpifw_ajax_url+'?action=wpifw_generate_invoice_packing_slip&order_ids='+order_ids+'&_wpnonce='+wpifw_ajax_obj.nonce;
                }

                window.open(URL,'_blank');

                return false;
            }

		});

        // set active of Setting tab

        // //To set default checked in setting tab if not found any localStorage value for active tab

        //set default setting tab active
           //$('#tab1').attr("checked", true);

        $("input[name='wf_tabs']").on('change',function () {
            var selectedTab = $(this).val();
            sessionStorage.setItem('active_tab', selectedTab);

        });

        var  activeTab = sessionStorage.getItem('active_tab');

        if(activeTab === "settings"){
            $('#tab1').attr("checked", true);

        }else if(activeTab === 'seller&buyer'){
            $('#tab2').attr("checked", true);

        }else if(activeTab === "localization"){
            $('#tab3').attr("checked", true);

        }else if(activeTab === 'bulk_download'){
            $('#tab4').attr("checked", true);

        }
        // set active of Setting tab ended


        //Bulk input date validation
        var from_date;
        var to_date;
        var toCheck   = 0;
        var fromCheck = 0;

        $('#Date-from').on('change',function(){
            from_date = Date.parse($(this).val());
            fromCheck = 1;
            if(toCheck && fromCheck){
                if(to_date<from_date){
                    alert("Input date should be less than or equal Date To");
                    $('#Date-from').val("");
                    fromCheck = 0;
                }
            }

        });

        $('#Date-to').on('change',function(){
            to_date = Date.parse($(this).val());
            toCheck = 1;
            if(toCheck && fromCheck){
                if(to_date<from_date){
                    alert("Input date should be greater than or equal Date From");
                    $('#Date-to').val("");
                    toCheck = 0;

                }
            }

        });

        $(function() {

            var tabs = $('.woo-invoice-sidebar-navbar-nav > li > a'); //grab tabs
            var contents = $('.woo-invoice-dashboard-content > li'); //grab contents

            if(sessionStorage.getItem('activeSidebarTab') != null ) {

                var activeSidebarTab = sessionStorage.getItem('activeSidebarTab');
                contents.hide(); //hide all contents
                tabs.removeClass('active'); //remove 'current' classes
                $(contents[activeSidebarTab]).show(); //show tab content that matches tab title index
                var activeTabSelector = $( ".woo-invoice-sidebar-navbar-nav > li:eq( "+activeSidebarTab+" ) > a" );
                activeTabSelector.addClass('active');
                /*$(this).addClass('active'); //add current class on clicked tab title*/
                $('.woo-invoice-dashboard-sidebar .woo-invoice-sidebar-navbar-light').height($(contents[activeSidebarTab]).parent().height()-23);
            } else {

                var initialContent = $( ".woo-invoice-dashboard-content > li:eq(0)" );
                initialContent.css('display','block'); //show tab content that matches tab title index
                var activeTabSelector = $( ".woo-invoice-sidebar-navbar-nav > li:eq(0) > a" );
                activeTabSelector.addClass('active');
                $('.woo-invoice-dashboard-sidebar .woo-invoice-sidebar-navbar-light').height(initialContent.parent().height()-23);
            }

            tabs.bind('click',function(e){
                e.preventDefault();
                var tabIndex = $(this).parent().prevAll().length;
                contents.hide(); //hide all contents
                tabs.removeClass('active'); //remove 'current' classes
                $(contents[tabIndex]).show(); //show tab content that matches tab title index
                $(this).addClass('active'); //add current class on clicked tab title
                
                var selectedSidebarTab = $(this).parent().prevAll().length;
                sessionStorage.setItem('activeSidebarTab', selectedSidebarTab);
                $('.woo-invoice-dashboard-sidebar .woo-invoice-sidebar-navbar-light').height(contents.parent().height()-23);
            });
        });


    });


    $(document).on('click', '.woo-invoice-template-selection', function (e) {
        e.preventDefault();
        let template = $(this).data('template');
        $('#winvoiceModalTemplates').modal('hide');
        $("body").removeClass (function (index, className) {
            return (className.match (/\S+-modal-open(^|\s)/g) || []).join(' ');
        });
        $('div[class*="-modal-backdrop"]').remove();
        $(this).find('img').removeClass('woo-invoice-template');
        $(this).find('img').removeClass('woo-invoice-disable-template');
        $(this).find('img').addClass('woo-invoice-slected-template');

        $(".woo-invoice-element-disable").find('img').addClass('woo-invoice-template');
        $(".woo-invoice-element-disable").find('img').removeClass('woo-invoice-disable-template');
        $(".woo-invoice-element-disable").css('z-index',"3333");
        $(".woo-invoice-element-disable").siblings("div").css('z-index',"1111");
        $(".woo-invoice-element-disable").siblings("a").css('z-index',"2222");

        $(this).parent().siblings().find('img').removeClass('woo-invoice-slected-template').addClass('woo-invoice-template');
        $.ajax({
            url: wpifw_ajax_obj.wpifw_ajax_url,
            type: 'post',
            data: {
                _ajax_nonce: wpifw_ajax_obj.nonce,
                action: "wpifw_save_pdf_template",
                template: template
            },
            success: function (response) {

                $('.woo-invoice-template-preview').attr('src','https://woo-invoice-assets.s3.amazonaws.com/template-image/'+response.data+'.png');

            }
        });

    });

    $(document).on('click', ".woo-invoice-element-disable", function (e) {
        e.preventDefault();
        $(this).children('img').removeClass('woo-invoice-template');
        $(this).children('img').addClass('woo-invoice-disable-template');
        $(this).css('z-index',"1111");
        $(this).siblings("div").css('z-index',"2222");
        $(this).siblings("a").css('z-index',"3333");
        
    });

    $(document).on('click', '.woo-pdf-review-notice ul li a', function (e) {
        e.preventDefault();
        let notice = $(this).attr('val');

        if(notice=="given"){
            window.open('https://wordpress.org/plugins/webappick-pdf-invoice-for-woocommerce/reviews/?rate=5#new-post','_blank');
        }

        $( ".woo-pdf-review-notice" ).slideUp( 200, "linear");

        $.ajax({
            url: wpifw_ajax_obj.wpifw_ajax_url,
            type: 'post',
            data: {
                _ajax_nonce: wpifw_ajax_obj.nonce,
                action: "save_review_notice",
                notice: notice
            },
            success: function (response) {

            }
        });
    });

    

    //Datepicker
    flatpickr(".woo-invoice-datepicker", {
        "dateFormat":"n/j/Y",
        "allowInput":true,
        "onOpen": function(selectedDates, dateStr, instance) {
            instance.setDate(instance.input.value, false);
        }
    });

    // Free vs premium slider
    $(window).load(function () {
        $('.woo-invoice-slider').slick({
            autoplay: true,
            dots: true,
            centerMode: true,
            arrows: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            lazyLoad: 'progressive'
        });
    });

})( jQuery );


