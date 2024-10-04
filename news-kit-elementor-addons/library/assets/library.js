( function( $ ) {
	"use strict";
	var NekitLibraryTemplateHandler = {
		sectionIndex: null,
		importIntialize: 0,
		contentID: 0,
		
		init: function() {
			window.elementor.on( 'preview:loaded', function() {
				NekitLibraryTemplateHandler.previewLoaded()
				NekitLibraryTemplateHandler.initiatePopup()
			});
		},

		previewLoaded: function() {
			var previewIframe = window.elementor.$previewContents, libraryButton = '<div id="nekit-library-btn" class="elementor-add-section-area-button" data-demo="pages" data-filter="all" style="background:url('+ libraryData.logoUrl +') no-repeat center center / contain; vertical-align: bottom; margin-left: 5px; background-size: 28px 22px; background-color: #4a2411; background-position: 62% 50%;"></div>';

			// Add Library Button
            var elementorAddSection = $("#tmpl-elementor-add-section"), elementorAddSectionText = elementorAddSection.text();
				elementorAddSectionText = elementorAddSectionText.replace('<div class="elementor-add-section-drag-title', libraryButton +'<div class="elementor-add-section-drag-title');
				elementorAddSection.text(elementorAddSectionText);
				
			$( previewIframe ).on( 'click', '.elementor-editor-section-settings .elementor-editor-element-add', function() {
				var addNewSectionWrap = $(this).closest( '.elementor-top-section' ).prev( '.elementor-add-section' ),
					modelID = $(this).closest( '.elementor-top-section' ).data( 'model-cid' );

				// Add Library Button
				if ( 0 == addNewSectionWrap.find( '#nekit-library-btn' ).length ) {
					setTimeout( function() {
						addNewSectionWrap.find( '.elementor-add-new-section' ).prepend( libraryButton );
					}, 110 );
				}
				
				// Set Section Index
				if ( window.elementor.elements.models.length ) {
					$.each( window.elementor.elements.models, function( index, model ) {
						if ( modelID === model.cid ) {
							NekitLibraryTemplateHandler.sectionIndex = index;
						}
					});
				}
				NekitLibraryTemplateHandler.contentID++;
			});

			NekitLibraryTemplateHandler.renderLibraryPopup(previewIframe)
		},
		renderLibraryPopup: function( previewIframe ) {
			$(previewIframe).on( "click", "#nekit-library-btn", function(e) {
				e.preventDefault()
				var popContainer = window.elementor.$previewContents.find("#nekit-library-btn"), demoToShow = popContainer[0].attributes['data-demo'].value, blockTypeToShow = popContainer[0].attributes['data-filter'].value
				$.ajax({
					method: 'GET',
					url: libraryData.ajaxUrl,
					data: {
						action: 'nekit_render_popup_modal',
						_wpnonce: libraryData._wpnonce
					},
					beforeSend: function() {
						popContainer.attr( "disabled", true )
						$e.run( 'panel/close' );
						var modalContainer = $(previewIframe).find("#nekit-library-popup")
						modalContainer.addClass("modal-active")
						modalContainer.find("#nekit-elementor-loading").show()
					},
					success : function(res) {
						var parsedRes = res.data
						if( res.success && parsedRes.loaded ) {
							popContainer.attr( "disabled", false )
							var modalContainer = $(previewIframe).find("#nekit-library-popup")
							modalContainer.prepend(parsedRes.html).promise().done(function() {
								modalContainer.find("#nekit-elementor-loading").hide()
								var popupContainer = $(this)
								popupContainer.find( '.filter-list' ).hide()

								// trigger close
								popupContainer.on( "click", ".popup-close-trigger", function() {
									var popupCloseElem = $(this)
									NekitLibraryTemplateHandler.endPopup(popupCloseElem)
									$e.run( 'panel/open' );
								})

								// filter templates library
								popupContainer.on( "click", ".header .templates-tabs .tab-title", function() {
									var templateTab = $(this)
									NekitLibraryTemplateHandler.filterTemplates(templateTab)
								})
								popupContainer.find( '.templates-tabs .tab-title[data-tab="' + demoToShow + '"]' ).trigger("click")
								
								// handle filter modal popup
								popupContainer.on( "click", ".widgets-category-title-filter .active-filter", function() {
									var blockTab = $(this)
									blockTab.next().toggle()
								})
								// close on outside click
								NekitLibraryTemplateHandler.closemodal( popupContainer.find(".widgets-category-title-filter"), function() {
									popupContainer.find(".widgets-category-title-filter .filter-list").hide()
								})
								// filter templates library
								popupContainer.on( "click", ".widgets-category-title-filter .filter-list .filter-tab", function() {
									var blockTab = $(this)
									NekitLibraryTemplateHandler.filterBlocks(blockTab)
								})
								popupContainer.find( '.widgets-category-title-filter .filter-list .filter-tab[data-value="' + blockTypeToShow + '"]' ).trigger("click")

								// on demo search filter templates library
								popupContainer.on( 'change keyup', '.filter-tab-search-wrap input[type="search"]', function() {
									var searchField = $(this)
									NekitLibraryTemplateHandler.filterOnSearch(searchField)
								})

								// ready for import
								if( NekitLibraryTemplateHandler.importIntialize == 0 ) import_data(popupContainer)
							})
						}
					},
					complete: function() {
						console.log( "completed" )
					}
				})
				window.elementor.$previewContents.find("#nekit-library-btn").attr( "data-demo", "pages" )
				window.elementor.$previewContents.find("#nekit-library-btn").attr( "data-filter", "all" )
			})
		},
		// initiate popup modal
		initiatePopup: function() {
			window.elementor.$previewContents.find('body').append( '<div id="nekit-library-popup"><div id="nekit-elementor-loading" class="nekit-elementor-loading" style="display: none;"><div class="elementor-loader-wrapper"><div class="elementor-loader" aria-hidden="true"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">' + libraryData.loadingText + '</div></div></div></div>' );
		},
		// filter templates
		filterTemplates: function(templateTab) {
			templateTab.addClass("isActive").siblings().removeClass("isActive")
			var templateContentPrefix = templateTab.data("tab")
			templateTab.parents(".header").next().find( "." + templateContentPrefix + "-tab-content" ).show().siblings().hide()
		},
		// filter templates
		filterBlocks: function(blockTab) {
			var blockType = blockTab.data("value"), blockName = blockTab.text()
			blockTab.parent().hide()
			blockTab.parent().prev().find(".filter-text").text(blockName)
			blockTab.parents(".filter-tab-search-wrap").next().find(".template-item." + blockType).siblings().removeClass("active").hide()
			blockTab.parents(".filter-tab-search-wrap").next().find(".template-item." + blockType).addClass("active").show()
		},
		// filter demos on search
		filterOnSearch: function(searchField) {
			var searchVal = searchField.val(), demoListItems = searchField.parents(".inner-tab-content").find(".tab-content-wrap .template-item")
			if( searchVal ) {
                demoListItems.each(function() {
                    var demoItem = $(this)
                    if( demoItem[0].classList.value.indexOf(searchVal) > 0 ) {
                        demoItem.addClass("active").show()
                    } else {
                        demoItem.removeClass("active").hide()
                    }
                })
            } else {
                demoListItems.addClass("active").show()
            }
		},
		// trigger modal close - on outside click
		closemodal( elm, callback ) {
			window.elementor.$previewContents.find("#nekit-library-popup").mouseup(function(e) {
				var container = $(elm);
				if (!container.is(e.target) && container.has(e.target).length === 0) callback();
			});
		},
		// close library popup
		endPopup: function(container) {
			container.parents("#nekit-library-popup").removeClass("modal-active")
		}
	};

	//  import widget data ajax action
	function import_data(container) {
		var popupCloseElem = container.find( ".popup-close-trigger" )
		container.on( "click", ".template-item .insert-data", function(e) {
			e.preventDefault()
			NekitLibraryTemplateHandler.importIntialize = 1
			var button = $(this), demo = button.data("route")
			$.ajax({
                method: 'POST',
                url: libraryData.ajaxUrl,
                data: {
                    action: 'nekit_import_widget_library_data',
                    demo: demo,
                    _wpnonce: libraryData._wpnonce
                },
                beforeSend: function() {
					button.attr( "disabled", true )
					container.parent().find("#nekit-library-popup #nekit-elementor-loading").show()
                },
                success : function(res) {
					if( res.success ) {
						var parsedRes = res.data
						window.elementor.getPreviewView().addChildModel( parsedRes.content, { at: NekitLibraryTemplateHandler.sectionIndex } );
						NekitLibraryTemplateHandler.sectionIndex = null
						container.parent().find("#nekit-library-popup #nekit-elementor-loading").hide()
						// trigger update post button
						window.elementor.panel.$el.find('#elementor-panel-footer-saver-publish button').removeClass('elementor-disabled');
						window.elementor.panel.$el.find('#elementor-panel-footer-saver-options button').removeClass('elementor-disabled');

						NekitLibraryTemplateHandler.endPopup(popupCloseElem)
						$e.run( 'panel/open' );
						button.attr( "disabled", false )
					}
                }
            })
		})
	}

	$( window ).on( 'elementor:init', NekitLibraryTemplateHandler.init );
}( jQuery ) );