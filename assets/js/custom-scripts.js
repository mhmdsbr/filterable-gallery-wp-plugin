( function ( $ )
{
	$( '.jrg-filter-form select' ).change( function ( e )
	{
		e.preventDefault();

		$.ajax( {
			url : jrg_js_object.ajax_url,
			type : 'post',
			dataType : 'json',
			data : $( '.jrg-filter-form' ).serialize(),
			success : function ( response )
			{
				if ( response.cities )
					$( 'select[name="city"]' ).html( response.cities );

				if ( response.years )
					$( 'select[name="year"]' ).html( response.years );

				$( '.jrg-gallery-items' ).html( response.gallery );
			}
		} );
	} );

	$( '.jrg-gallery-items' ).magnificPopup( {
		delegate : 'a',
		type : 'image',
		tLoading : 'Loading ...',
		gallery : {
			enabled : true,
			navigateByImgClick : true,
			preload : [ 0, 1 ]
		},
		image : {
			titleSrc : function ( item )
			{
				let figCaption = '<span class="jrg-city">' + item.el.attr( 'data-city' ) + '</span>';
				figCaption += '<span class="jrg-country">' + item.el.attr( 'data-country' ) + '</span>';
				figCaption += '<span class="jrg-year">' + item.el.attr( 'data-year' ) + '</span>';
				figCaption += '<span class="jrg-desc">' + item.el.attr( 'data-desc' ) + '</span>';

				return figCaption
			}
		}
	} );

		$(document).ready(function() {
		  $('#country-select').niceSelect();
		  $('#country-select').niceSelect('update');
		  $('#city-select').niceSelect();
		  $('#city-select').niceSelect('update');
		  $('#year-select').niceSelect();
		  $('#year-select').niceSelect('update');
		});

} )( jQuery );