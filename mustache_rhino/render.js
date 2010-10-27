// Pipe a JSON object to this script. The object would have these properties:
// {
//     templatesDir: '/Full/path/to/templates/dir',
//     template: 'template-name',
//     data: {foo: 'some data to insert into the template', bar: '1234'}
// }

function collectInput() {
    // The same as: import java.io.*;
    importPackage(java.io);
    importPackage(java.lang);
     
    // "in" is a keyword in Javascript. 
    // In Rhino you could query for an attribute using [] syntax: 
    // Ex: System['out']
    var input = new BufferedReader( new InputStreamReader(System['in']) );
    var tmpStr = "";
    var buf = "";
    
    while (true) {
        tmpStr = input.readLine();
        if (!tmpStr) {
            break;
        }
        buf += tmpStr;
    }
    
    return buf;
}

function collectTemplates(templatesDir) {
    importPackage(java.io);
    importPackage(java.lang);

    var templates = {};
    var dir = new File(templatesDir);
    var files = dir.list();
    var i;
    var match;
    for (i = 0; i < files.length; i += 1) {
        match = files[i].match(/([^\/\.]*)\.mustache$/);
        if (match) {
            templates[match[1]] = readFile(templatesDir + '/' + match[1] + '.mustache');
        }
    }
    
    return templates;
}

buf = collectInput();
params = eval('(' + buf + ')');
var templates = collectTemplates(params.templatesDir);

load(params['mustacheFile']);
System.out.print(Mustache.to_html(templates[params.template], params.data, templates));

