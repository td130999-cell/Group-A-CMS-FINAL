( function( api ) {

	// Extends our custom coffee-cafe-corner-pro section.
	api.sectionConstructor['coffee-cafe-corner-pro'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
