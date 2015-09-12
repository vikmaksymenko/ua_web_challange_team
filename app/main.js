var app = require('express')();
var bodyParser = require('body-parser');

app.use(bodyParser.json()); // for parsing application/json
app.use(bodyParser.urlencoded({ extended: true })); // for parsing application/x-www-form-urlencoded

app.get('/', function (req, res) {
	res.send('Hello World!');
});

app.post('/login', function (req, res) {
	var credentials = req.body;
	
	if(credentials.login === credentials.password && credentials.login === 'admin') {
		res.send({success: true});
	} else {
		res.send({success: false});
	}
//	console.log(req.body);
//	res.send('POST request send with: ' + req);
});

var server = app.listen(3000, function () {
	var host = server.address().address;
	var port = server.address().port;

	console.log('Example app listening at http://%s:%s', host, port);
})