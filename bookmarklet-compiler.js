/**
 * Bookmarklet Compiler
 * 
 * @copyright Moxley Stratton - http://www.moxleystratton.com/
 */

window.Bookmarklet = {
  compileBody: function (source) {
    source = source.replace(/[\t\r\n]/g, ''); // Remove tabs, newlines
    source = source.replace(/\/\*[^*]*\*\//, ''); // Remove multi-line comments; This needs more work
    source = escape(source);
    return source;
  },
  makeURL: function (sourceCode) {
    return 'javascript:(function(){' + this.compileBody(sourceCode) + '}());';
  },
  forPost: function () {
    var source = document.getElementById('source').value;
    var display = document.getElementById('display');
    var url = this.makeURL(source);
    var container = document.getElementById('generated');
    for (var i = 0; i < container.childNodes.length; i++) {
      container.removeChild(container.childNodes[i]);
    }
    var a = document.createElement('a');
    a.href = url;
    var text = document.createTextNode('> > > Bookmark this link');
    a.appendChild(text);
    container.appendChild(a);
    document.getElementById('source').style.height = '2em';
  }
};
