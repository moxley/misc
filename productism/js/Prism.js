/**
 * Productism main JavaScript.
 */
Prism = Ext.extend(Ext.Viewport, {
    constructor: function () {
	var self = this;

	Prism.superclass.constructor.call(self, {
	    renderTo: Ext.getBody(),
	    layout: 'border',
	    items: [
		{
		    region: 'north',
		    title: 'Menu'
		},
		{
		    region: 'center',
		    title: 'Product Management',
		    items: [
			{
			    html: 'item 1'
			}
		    ]
		}
	    ]
	});
    }
});

Prism.render = function () {
    return new Prism();
};
