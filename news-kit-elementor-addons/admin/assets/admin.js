jQuery(document).ready(function($) {
    "use strict"

    const NekitAdminHandler = {
        init: function() {
            switch( adminObject.page ) {
                case 'nav-menus.php': NekitAdminHandler.navLoad()
                                break;
                case 'news-kit_page_news-kit-elementor-addons-theme-builder':
                                        NekitAdminHandler.adminpageLoad()
                                break;
                case 'news-kit_page_news-kit-elementor-addons-settings': 
                                        NekitAdminHandler.adminSettingsPage()
                                break;
            }
            $(".nekit-admin-modal").on( "click", ".nekit-modal-close", function() {
                $(this).parents(".nekit-admin-modal").fadeToggle( "fast", "linear" );
            })
        },
        urlParam: function(name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        },
        adminSettingsPage: function() {
            console.log(this.urlParam('page'))
        },
        adminpageLoad: function() {
            var admincontainer = $("#nekit-admin-page")
            // on template create
            admincontainer.on( "click", ".show-create-template-form", function() {
                $("#nekit-create-template-modal").fadeToggle( "fast", "linear" )
                $("#nekit-create-template-modal").find( 'input[name="template-name"]' ).focus()
            })
            var adminFormContainer = $("#nekit-create-template-modal")
            adminFormContainer.on( "click", ".create-new-template", function() {
                var _this = $(this), templateName = adminFormContainer.data("template")
                var templateNameElm = adminFormContainer.find( 'input[name="template-name"]' )
                var templateTitle = templateNameElm.val()
                if( ! templateTitle) {
                    adminFormContainer.find(".empty-message-field").remove()
                    templateNameElm.removeClass("empty-field").addClass("empty-field")
                    templateNameElm.after(`<span class="empty-message-field">${adminObject.emptyFieldText}</span>`);
                    templateNameElm.on( "change", function(e) {
                        if(e.target.value) {
                            adminFormContainer.find(".empty-message-field").remove()
                            templateNameElm.removeClass("empty-field")
                        }
                    })
                } else {
                    $.ajax({
                        method: 'POST',
                        url: adminObject.ajaxUrl,
                        data: {
                            action: 'nekit_create_template_action',
                            template: templateName,
                            templateTitle: templateTitle,
                            _wpnonce: adminObject._wpnonce
                        },
                        beforeSend: function() {
                            adminFormContainer.addClass( "loading-process" )
                        },
                        success : function(res) {
                            var parsedRes = res.data
                            if( res.success && parsedRes.updated ) {
                                if(parsedRes.updated) {
                                    adminFormContainer.removeClass( "loading-process" )
                                    $("#nekit-builder-create-form").find('input[type="hidden"][name="condition_id"]').val(parsedRes.post_id)
                                    $("#nekit-builder-create-form").submit()
                                }
                            }
                        }
                    })
                }
            })

            // for 404 template
            admincontainer.on( "click", ".template-list-item .error-page-switch", function() {
                var _thisActiveLabel = $(this), templateID = 0
                if( ! _thisActiveLabel.hasClass('isactive') ) {
                    var parentElm = _thisActiveLabel.parent()
                    templateID = parentElm.data("template")
                    _thisActiveLabel.addClass("isactive")
                    _thisActiveLabel.find(".error-page-switch-label").text( adminObject.enabledText )
                    parentElm.siblings().find(".error-page-switch").removeClass("isactive").find(".error-page-switch-label").text( adminObject.disabledText )
                } else {
                    _thisActiveLabel.removeClass("isactive")
                    _thisActiveLabel.find(".error-page-switch-label").text( adminObject.disabledText )
                }
                $.ajax({
                    url: adminObject.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'nekit_404_builder_active',
                        option: templateID,
                        _wpnonce: adminObject._wpnonce
                    },
                    beforeSend: function() {
                        _thisActiveLabel.parent().addClass( "loading-process")
                    },
                    success: function( result ) {
                        console.log( result )
                    }
                })
            })

            // on template delete
            admincontainer.on( "click", ".show-delete-template-form", function() {
                var deleteDialogTriggerButton = $(this), templateId = deleteDialogTriggerButton.data("template-id")
                $("#nekit-delete-template-modal").attr("data-template-id",templateId).fadeToggle("fast")
            })
            var deleteDialogContainer = $("#nekit-delete-template-modal")
            deleteDialogContainer.on( "click", ".delete-old-template", function() {
                var deleteTemplateButton = $(this),
                parentContainer = deleteTemplateButton.parents("#nekit-delete-template-modal"),
                templateID = parentContainer.data("template-id"),
                templateName = parentContainer.data("template")
                $.ajax({
                    method: 'POST',
                    url: adminObject.ajaxUrl,
                    data: {
                        action: 'nekit_delete_template_action',
                        template: templateName,
                        template_id: templateID,
                        _wpnonce: adminObject._wpnonce
                    },
                    beforeSend: function() {
                        deleteDialogContainer.addClass( "loading-process" )
                    },
                    success : function(res) {
                        var parsedRes = res.data
                        if( res.success && parsedRes.deleted ) {
                            $('.template-list-item[data-template="' + templateID +  '"]').remove()
                            deleteDialogContainer.fadeToggle("fast")
                            deleteDialogContainer.removeClass( "loading-process" )
                            location.reload();
                        }
                    }
                })
            })
            deleteDialogContainer.on( "click", ".cancel-delete-old-template", function() {
                var cancelDeleteTemplateButton = $(this), parentContainer = cancelDeleteTemplateButton.parents("#nekit-delete-template-modal")
                parentContainer.fadeToggle("fast")
            })

            // on conditions input field changes
            admincontainer.on( "change", "select.template-display-pages", function() {
                var _this = $(this), newValue = _this.val()
                // trigger callback
                if( newValue == 'archives' || newValue == 'singular' ) {
                    _this.siblings(".template-display-" + newValue + "-pages").show()
                    if( newValue == 'archives' ) _this.siblings(".template-display-singular-pages").hide()
                    if( newValue == 'singular' ) _this.siblings(".template-display-archives-pages").hide()
                } else if( newValue == 'posts' || newValue == 'pages' || newValue == 'archiveauthor' || newValue == 'archivepostcategories' || newValue == 'archiveposttags' ) {
                    _this.siblings(".template-display-post_type-ids").show()
                } else {
                    _this.siblings(".template-display-archives-pages").hide()
                    _this.siblings(".template-display-singular-pages").hide()
                    _this.siblings(".template-display-post_type-ids").hide()
                }
            })
            
            // on condition delete row
            $(document).on( "click", ".nekit-manage-condition-modal .delete-field-group .delete-row", function() {
                var _deleteThis = $(this), conditionRow = _deleteThis.parents(".condition-field-group")
                conditionRow.slideUp(400, function() {
                    $(this).remove()
                })
            })

            // popup manage condition modal
            admincontainer.on( "click", ".manage-template-conditions", function() {
                var _this = $(this), parentContainer = _this.parents(".template-list-item")
                parentContainer.next(".nekit-manage-condition-modal").fadeToggle( "fast", "linear" );
            })

            // save conditions
            admincontainer.on( "click", ".save-conditions", function(e) {
                e.preventDefault()
                var _this = $(this), _thisText = _this.text(), templateId = _this.parents(".nekit-manage-condition-modal").data("template-id"), modalParentCotnainer = _this.parents(".nekit-manage-condition-modal"), valuefieldsGroup = modalParentCotnainer.find(".inner-fields-group-wrap .condition-field-group .condition-field-inner-group")
                if(valuefieldsGroup.length > 0) {
                    var pages = [], conditions = []
                    valuefieldsGroup.each(function(valuefieldsGroupIndex) {
                        var innerThis = $(this), conditionType = innerThis.find("select.template-condition-type").val(), parentPage = innerThis.find("select.template-display-pages").val(), childPage = '';
                        if( parentPage == 'archives' ) childPage = innerThis.find("select.template-display-archives-pages").val()
                        if( parentPage == 'singular' ) childPage = innerThis.find("select.template-display-singular-pages").val()
                        if( parentPage == 'posts' || parentPage == 'pages' || parentPage == 'archiveauthor' || parentPage == 'archivepostcategories' || parentPage == 'archiveposttags'  ) { // on parent page posts and pages
                            if( innerThis.find("input.template-display-post_type-ids").val() ) {
                                var ids = innerThis.find("input.template-display-post_type-ids").val(), idsArray = ids.split(",")
                                const idsArrayTrimed = idsArray.map(element => {
                                    return 'nekit' + element.trim() + 'nekit';
                                });
                                childPage = idsArrayTrimed.join(",")
                            } else {
                                childPage = 'nekitallnekit'
                            }
                        }
                        var page = (childPage !== '') ? parentPage + '-' + childPage : parentPage;
                        if( ! pages.includes(page) ) pages.push(page)
                        conditions.push(conditionType)
                        if( ( valuefieldsGroupIndex + 1 ) == valuefieldsGroup.length ) {
                            $.ajax({
                                method: 'POST',
                                url: adminObject.ajaxUrl,
                                data: {
                                    action: 'nekit_update_templates_meta_action',
                                    pages: JSON.stringify(pages),
                                    templateId: templateId,
                                    conditions: JSON.stringify(conditions),
                                    _wpnonce: adminObject._wpnonce
                                },
                                beforeSend: function() {
                                    _this.text( adminObject.savingText ).attr( "disabled", true )
                                },
                                success : function(res) {
                                    var parsedRes = res.data
                                    if( res.success && parsedRes.updated ) {
                                        _this.text(_thisText).attr( "disabled", false )
                                        _this.parents(".nekit-manage-condition-modal").find(".nekit-modal-close").trigger("click")
                                        console.log(parsedRes)
                                    }
                                }
                            })
                        }
                    })
                } else { // when condition is empty
                    $.ajax({
                        method: 'POST',
                        url: adminObject.ajaxUrl,
                        data: {
                            action: 'nekit_update_templates_meta_action',
                            templateId: templateId,
                            isEmpty: true,
                            _wpnonce: adminObject._wpnonce
                        },
                        beforeSend: function() {
                            _this.text( adminObject.savingText ).attr( "disabled", true )
                        },
                        success : function(res) {
                            var parsedRes = JSON.parse(res)
                            if( parsedRes.updated ) {
                                _this.text(_thisText).attr( "disabled", false )
                                console.log(parsedRes)
                            }
                        }
                    })
                }
            })
            
            // add conditions
            admincontainer.on( "click", ".add-condition", function() {
                var _this = $(this), parentElement = _this.parent(), conditionHtml = parentElement.prev(".condition-identical-group").html(), moveToHtml = parentElement.siblings(".inner-fields-group-wrap")
                moveToHtml.append(conditionHtml)
            })

            // on demo import 
            $(".import-demo").on( "click", function() {
                var demoId = $(this).data("demo")
                $.ajax({
                    method: 'POST',
                    url: adminObject.ajaxUrl,
                    data: {
                        action: 'nekit_import_template_action',
                        demoId: demoId,
                        _wpnonce: adminObject._wpnonce
                    },
                    beforeSend: function() {
                    },
                    success : function(res) {
                        var parsedRes = res.data
                        if( res.success && parsedRes.loaded ) {
                            console.log(parsedRes)
                        }
                    }
                })
            })
        },
        // nav menus
        navLoad: function() {
            // close elementor editor
            $(document).on( "click", ".nekit-mega-menu-modal .tab-edit-content .mega-menu-inner-close-btn", function() {
                console.log( "close elementor editor" )
                $(this).parent().hide()
            })

            var navContainerForm = $("#nav-menus-frame #update-nav-menu")
            var navMenuItems = navContainerForm.find( "#post-body #menu-to-edit .menu-item" )
            navMenuItems.each(function() {
                var _this = $(this)
                _this.find( ".menu-item-bar .menu-item-handle" ).append( '<span class="nekit-menu-button mega-menu-tigger"><span class="news_kit_logo">Ne</span>' + adminObject.buttonText +  '</span>' ).promise().done(function() {
                    var menuItemContainer = $(this)
                    menuItemContainer.on( "click", ".nekit-menu-button.mega-menu-tigger", function() {
                        var megaMenuTrigger = $(this), menuItemId = megaMenuTrigger.parents(".menu-item").attr("id"), menuItemName = megaMenuTrigger.parents(".menu-item").find(".menu-item-title").text()
                        $.ajax({
                            method: 'POST',
                            url: adminObject.ajaxUrl,
                            data: {
                                action: 'nekit_render_mega_menu_modal',
                                menu: menuItemId,
                                menu_name: menuItemName,
                                _wpnonce: adminObject._wpnonce
                            },
                            beforeSend: function() {
                            },
                            success : function(res) {
                                var parsedRes = res.data
                                if( res.success && parsedRes.loaded ) {
                                    $("body").find( ".nekit-mega-menu-modal" ).remove()
                                    $("body").append(parsedRes.html).promise().done(function() {
                                        var modalElm = $(this).find(".nekit-mega-menu-modal")
                                        handleSaveForm(modalElm)
                                        handleSaveField(modalElm)
                                        handleSwitchField(modalElm)
                                        handleIconPickerField(modalElm)
                                        handleMinimizeHeader(modalElm)
                                        endPopup(modalElm)
                                        handleTabToggle(modalElm)
                                        handleResponsiveField(modalElm)
                                        embedColorPickerField(modalElm)
                                        handleEditWithElementor(modalElm)
                                    })
                                }
                            }
                        })
                    })
                })
            })
        },
        onElementOutsideClick: function(currentElement, callback) {
            $(document).mouseup(function (e) {
                var container = $(currentElement);
                if (!container.is(e.target) && container.has(e.target).length === 0) callback();
            })
        }
    }
    
    // handle tab toggle
    function handleTabToggle(modalContainer) {
        var tabsContainer = modalContainer.find(".tabs-title-wrap"), currentTabContent = modalContainer.find(".tab-content")
        tabsContainer.on( "click", ".tab-title", function() {
            var _this = $(this), currentTab = _this.data("tab")
            _this.addClass("active-tab").siblings().removeClass("active-tab")
            currentTabContent.find(".tab-" + currentTab + "-content").show().siblings().hide()
        })
    }
    
    // handle responsive fields
    function handleResponsiveField(modalElm) {
        modalElm.on( "click", ".nekit-responsive-field-trigger", function(e) {
            e.preventDefault()
            var _responsiveButton = $(this), newDeviceClass = 'dashicons dashicons-desktop', newDeviceTitleAttr = adminObject.desktopText, newDevice = 'desktop', currentDevice = _responsiveButton.find("span").attr("class")
            if( currentDevice == 'dashicons dashicons-desktop' ) {
                newDeviceClass = 'dashicons dashicons-tablet'
                newDeviceTitleAttr = adminObject.tabletText
                newDevice = 'tablet'
            } else if( currentDevice == 'dashicons dashicons-tablet' ) {
                newDeviceClass = 'dashicons dashicons-smartphone'
                newDeviceTitleAttr = adminObject.mobileText
                newDevice = 'phone'
            }
            var currentControlParentItem = _responsiveButton.parent(".nekit-mega-menu-setting-field")

            currentControlParentItem.find(".control-" + newDevice).show().siblings(".field-link").hide()
            // make alter to other responsive controls
            currentControlParentItem.siblings().find(".nekit-responsive-field-trigger").find("span").removeClass().addClass(newDeviceClass).attr("title",newDeviceTitleAttr)
            currentControlParentItem.siblings().find(".control-" + newDevice).show().siblings(".field-link").hide()
            _responsiveButton.find("span").removeClass().addClass(newDeviceClass).attr("title",newDeviceTitleAttr)
        })
    }
    
    // embed color picker field on element
    function embedColorPickerField(modalContainer) {
        var settingsForm = modalContainer.find("form.nekit-mega-menu-setting-form"), formFieldsSubmitContainer = settingsForm.find('input[type="submit"]')
        modalContainer.find(".nekit-color-field").wpColorPicker({
            change: function() {
                formFieldsSubmitContainer.attr( "disabled", false )
                formFieldsSubmitContainer.val( adminObject.formButtonText )   
            }
        })
    }

    // scripts for handling the switch toggle field
    function handleSwitchField(modalContainer) {
        var inputField = modalContainer.find('.mega-menu-toggle-field .field-input'), menuItemId = inputField.data("menu")
        modalContainer.on('change', '.mega-menu-toggle-field input[type="checkbox"]', function() {
            var newValue = 'disable'
            if( $(this).is(":checked") ) {
                inputField.removeClass("disable").addClass("enable")
                inputField.attr("data-value",'enable')
                newValue = 'enable'
            } else {
                inputField.removeClass("enable").addClass("disable")
                inputField.attr("data-value",'disable')
            }
            $.ajax({
                method: 'POST',
                url: adminObject.ajaxUrl,
                data: {
                    action: 'nekit_update_mega_menu_option_val',
                    menu: menuItemId,
                    value: newValue,
                    _wpnonce: adminObject._wpnonce
                },
                beforeSend: function() {
                },
                success : function(res) {
                    var parsedRes = res.data
                    if( res.success && parsedRes.updated ) {
                        console.log(parsedRes.updated)
                    }
                }
            })
        })
    }
    
    // 
    function handleMinimizeHeader(modalContainer) {
        modalContainer.on( "click", ".nekit-menu-toggle-arrow", function() {
            var _thisToggler = $(this);
            _thisToggler.toggleClass('megamenu-admin-hide-arrow');
            _thisToggler.next().slideToggle()
        })
    }

    // handles the script for icon picker fields
    function handleIconPickerField(modalContainer) {
        var iconPickerContainer = modalContainer.find(".icon-picker-field")
        if( iconPickerContainer.length > 0 ) {
            iconPickerContainer.each(function() {
                var pickerModal = $(this).find(".icon-picker-modal"), fieldElm = $(this).find(".icon-picker-holder > .field-link"), selectedIcon = fieldElm.val(), iconHolder = $(this).find(".icon-picker-holder .icon-value")
                // on icon modal trigger
                $(this).on( "click", ".icon-picker-holder .icon-value", function() {
                    var _this = $(this)
                    _this.parents(".icon-picker-holder").next().toggle()
                })

                // on modal close trigger
                pickerModal.on( "click", ".modal-close", function() {
                    var _this = $(this)
                    _this.parents(".icon-picker-modal").toggle()
                })

                // on search field change
                pickerModal.on( "change keyup", ".icon-search-field", function() {
                    var _thisSearchField = $(this), iconList = pickerModal.find( ".icons-list .icon-item i" )
                    if( _thisSearchField.val() ) {
                        iconList.each(function() {
                            if( $(this).attr("class").indexOf(_thisSearchField.val() ) < 0 ) {
                                $(this).parent().hide()
                            } else {
                                $(this).parent().show()
                            }
                        })
                    } else {
                        iconList.parent().show()
                    }
                })

                // find inner field and run script for it
                var innerToggleField = $(this).find(".inner-field.toggle-field")
                innerToggleField.on( "click", ".toggle-item", function() {
                    var currentToggleVal = innerToggleField.find(".field-link").val()
                    innerToggleField.toggleClass("show hide")
                    var newCurrentToggleVal = ( currentToggleVal == 'hide' ) ? 'show' : 'hide';
                    innerToggleField.find(".field-link").val(newCurrentToggleVal).trigger("change")
                })

                // change the position of selected icon
                pickerModal.find(".icon-item.selected").prependTo(pickerModal.find(".icons-list"))

                // on icon select
                pickerModal.on( "click", ".icon-item", function() {
                    var _this = $(this)
                    _this.addClass("selected").siblings().removeClass("selected")
                    selectedIcon = _this.find("i").attr("class")
                    iconHolder.find("i").removeClass().addClass(selectedIcon)
                    fieldElm.val(selectedIcon).trigger("change")
                })
            })
        }
    }

    // scripts to handling the function to save settings
    function handleSaveField(modalContainer) {
        var settingsForm = modalContainer.find("form.nekit-mega-menu-setting-form"), formFieldsSubmitContainer = settingsForm.find('input[type="submit"]')
        if( settingsForm.length > 0 ) {
            settingsForm.on( "change", ".field-link", function() {
                formFieldsSubmitContainer.attr( "disabled", false )
                formFieldsSubmitContainer.val( adminObject.formButtonText )
            })
        }
    }

    // handle edit with elementor modal popup
    function handleEditWithElementor(modalElm) {
        var editAreaTriggerButton = modalElm.find( ".nekit-editwith-elementor" )
        var editAreaContainer = modalElm.find( ".tab-content .tab-edit-content" )
        editAreaTriggerButton.on( "click", function() {
            editAreaContainer.toggle()
        })
    }

    // scripts to handling the function to save form settings
    function handleSaveForm(modalContainer) {
        var settingsForm = modalContainer.find("form.nekit-mega-menu-setting-form"), settingsFormID = settingsForm.attr("id"), formFieldsSubmitContainer = settingsForm.find('input[type="submit"]')
        if( settingsForm.length > 0 ) {
            settingsForm.submit(function(e) {
                e.preventDefault()
                var _innerThis = $(this), formData = _innerThis.serializeArray()
                const formValues = formData.map((singleField) => {
                    return {
                        name: singleField.name.replace(/[\[\]0-9]/g,""),
                        value: singleField.value
                    }
                })
                var stringifiedFormValues = JSON.stringify(formValues)
                if( ( typeof settingsFormID == 'string' ) ) settingsFormID = parseInt(settingsFormID.replace(/[^0-9]/g,""))
                // write ajax function to update the settings
                    $.ajax({
                        method: 'POST',
                        url: adminObject.ajaxUrl,
                        data: {
                            action: 'nekit_update_mega_menu_form',
                            menu: settingsFormID,
                            formData: stringifiedFormValues,
                            _wpnonce: adminObject._wpnonce
                        },
                        beforeSend: function() {
                            formFieldsSubmitContainer.attr( "disabled", true )
                            formFieldsSubmitContainer.val( adminObject.savingText )
                        },
                        success: function(res) {
                            var parsedRes = res.data
                            if( res.success && parsedRes.updated ) {
                                console.log(parsedRes.updated)
                            }
                        },
                        complete: function() {
                            formFieldsSubmitContainer.val( adminObject.formButtonSavedText )
                        }
                    })
            })
        }
    }

    // close modal popup
    function endPopup(modalContainer) {
        modalContainer.on( "click", ".popup-close-trigger", function() {
            $(this).parents(".nekit-mega-menu-modal").remove()
        })
    }

    // template list -- pages demo listing page
    var sapSectionContainer = $(this).find(".nekit-templates-list")
    if( sapSectionContainer.length > 0 ) {
        var demoListItems = sapSectionContainer.find(".pages-library .template-item")
        var blockDemoListItems = sapSectionContainer.find(".widgets-blocks-library .template-item")
        var widgetsLibraryContainer = $( ".pre-built-block-wrap .tab-blocks-list.widgets-blocks-library" )
        let $masonry = widgetsLibraryContainer.masonry({
            itemSelector: ".template-item",
            horizontalOrder: true,
            gutter: 30,
        });
        $masonry.imagesLoaded().progress(function () {
            $masonry.masonry("layout");
        });

        // filter page demos
        sapSectionContainer.on( "click", ".main-demo-list-tabs .list-item", function() {
            var _this = $(this), tabLabel = _this.text().toLowerCase()
            _this.addClass("isActive").siblings().removeClass("isActive")
            var mainParentSibling = _this.parents('.page-header').siblings()
            var classToFind = mainParentSibling.find( '.template-item.' + tabLabel )
            mainParentSibling.find( '.template-item' ).hide()
            classToFind.show()
        })

        // filter page demos type
        sapSectionContainer.on( "change", ".demo-type-filter", function() {
            var _this = $(this), type = _this.val()
            var mainParentSibling = _this.parents('.page-header').siblings()
            var classToFind = mainParentSibling.find( '.template-item.' + type )
            mainParentSibling.find( '.template-item' ).hide()
            classToFind.show()
        })

        // on pages demo search
        sapSectionContainer.on( 'change keyup', '.filter-search-wrap input[type="search"]', function() {
            var searchField = $(this), searchVal = searchField.val()
            if( searchVal ) {
                demoListItems.each(function() {
                    var demoItem = $(this)
                    if( demoItem[0].classList.value.indexOf(searchVal) > 0 ) {
                        demoItem.show()
                    } else {
                        demoItem.hide()
                    }
                })
            } else {
                demoListItems.show()
            }
        })

        // on blocks demo search
        sapSectionContainer.on( 'change keyup', '.filter-tab-search-wrap input[type="search"]', function() {
            var searchField = $(this), searchVal = searchField.val()
            if( searchVal ) {
                blockDemoListItems.each(function() {
                    var demoItem = $(this)
                    if( demoItem[0].classList.value.indexOf(searchVal) > 0 ) {
                        demoItem.show()
                    } else {
                        demoItem.hide()
                    }
                })
            } else {
                blockDemoListItems.show()
            }
            // $masonry.destroy()
            widgetsLibraryContainer.masonry({
                itemSelector: ".template-item",
                horizontalOrder: true,
                gutter: 30,
            });
        })

        // handle plugin install button
        sapSectionContainer.on( "click", ".importer-action", function() {
            var _thisInstallButton = $(this)
            $.ajax({
                method: 'POST',
                url: adminObject.ajaxUrl,
                data: {
                    action: 'nekit_install_importer',
                    option: _thisInstallButton.hasClass( "install" ) ? 'install' : 'activate',
                    _wpnonce: adminObject._wpnonce
                },
                beforeSend: function() {
                    _thisInstallButton.attr( "disabled", true )
                    _thisInstallButton.addClass('installing-importer')
                    if( _thisInstallButton.hasClass( "install" ) ) _thisInstallButton.hide().html('').fadeIn().html( adminObject.installingText );
                    if( _thisInstallButton.hasClass( "activate" ) ) _thisInstallButton.hide().html('').fadeIn().html( adminObject.activatingText );
                },
                success: function( result ) {
                    var info = result.data
                    if( ! info.status ) {
                        _thisInstallButton.hide().html('').fadeIn().html(info.message);
                    }
                },
                complete: function() {
                    _thisInstallButton.attr( "disbaled", false )
                    _thisInstallButton.removeClass('installing-importer')
                    location.reload()
                }
            })
        })
    }

    //Pre-Made Blocks Filter
    var titleFilterSectionContailer = $(this).find('.widgets-category-title-filter')
    titleFilterSectionContailer.find( '.filter-list' ).hide()
    titleFilterSectionContailer.find( '.active-filter' ).click(function(){
        $(this).siblings().toggle()
    })
    if( titleFilterSectionContailer.length > 0 ) {
        var filterBy = titleFilterSectionContailer.find( '.filter-tab' )
        filterBy.click(function(){
            var _this = $(this)
            var filterValue = _this.data('value')
            var findingSelectedPreviews = titleFilterSectionContailer.parent().siblings().find( '.' + filterValue )
            findingSelectedPreviews.show().siblings().hide()
            titleFilterSectionContailer.find( '.filter-list' ).hide()
            if( filterValue == 'all' ) findingSelectedPreviews.show()
        })
    }

    NekitAdminHandler.init()
})