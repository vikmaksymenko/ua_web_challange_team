var assert = require("assert");
var request = require('request');

describe('Login', function() {
	it('should return POST from /login', function(done) {
		request.post('http://localhost:3000/login', {form: {login: 'admin', password: 'admin' }}, function(error, response, body) {
			if(!error) {
				assert.equal(JSON.parse(body).success, true, 'Unable to login under admin account');
				done();
			}
		})
	});
});