
import axios from 'axios';
import qs from 'qs';
function ajax() {
	var o = {
		url: '',
		params: {},
		okCallback: function(data) {
		},

		notOkCallback: function(data) {
		},

		errorCallback: function(error) {

		},

		post: function(url, params) {
			this.url = url;
			this.params = params;
			return this;
		},

		ok: function(callback) {
			this.okCallback = callback;
			return this;
		},

		notOk: function(callback) {
			this.notOkCallback = callback;
			return this;
		}, 

		catch: function(callback) {
			this.errorCallback = callback;
			return this;
		},

		start: function() {
			let that = this;
			let instance = axios.create({
		  			headers: { 'content-type': 'application/x-www-form-urlencoded' },
		  			withCredentials: true 
		  		});
			instance.post(this.url,
				qs.stringify(this.params))
			.then(function (response) {
				if (response.data.code == 200) {
					that.okCallback(response.data);
				} else {
					that.notOkCallback(response.data);
				}
			}).catch(this.errorCallback);		
		
		}
	}
	return o;
}
function ajaxPost(url, params, okCallback, notOkCallback, errorCallback) {	
	
}

export {ajax}
