function Ajax(file) {
    if (this instanceof arguments.callee){
        this.xhr = null;
        this.method = "POST";
        this.queryStringSeparator = "?";
        this.argumentSeparator = "&";
        this.URLString = "";
        this.encodeURIString = true;
        this.execute = false;
        this.element = null;
        this.elementObj = null;
        this.requestFile = file;
        this.failed = false;
        this.vars = new Object();
        this.responseStatus = new Array(2);

        this.onLoading = function() { };
        this.onLoaded = function() { };
        this.onInteractive = function() { };
        this.onCompletion = function() { };
        this.onError = function() { };
        this.onFail = function() { };

        if (typeof this.createXHR != "function"){
            Ajax.prototype.createXHR = function() {
                if (typeof XMLHttpRequest != "undefined"){
                    Ajax.prototype.createXHR = function(){
                        this.xhr = new XMLHttpRequest();
                    };
                } else if (typeof ActiveXObject != "undefined"){
                    Ajax.prototype.createXHR = function(){
                        if (typeof arguments.callee.activeXString != "string"){
                            var versions = ["MSXML2.XMLHttp.6.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp"];
                            for (var i=0,len=versions.length; i < len; i++){
                                try {
                                    this.xhr = new ActiveXObject(versions[i]);
                                    arguments.callee.activeXString = versions[i];
                                    break;
                                } catch (e){
                                //skip
                                }
                            }
                        }else{
                            this.xhr = new ActiveXObject(arguments.callee.activeXString);
                        }
                    };
                } else {
                   Ajax.prototype.createXHR = function(){
                        this.failed = true;
                        throw new Error("No XMLHttpRequest object available.");
                    };
                }
                return this.createXHR();
            };

            Ajax.prototype.setVar = function(name, value){
                this.vars[name] = Array(value, false);
            };

            Ajax.prototype.encVar = function(name, value, returnvars) {
                if (true == returnvars) {
                    return Array(encodeURIComponent(name), encodeURIComponent(value));
                } else {
                    this.vars[encodeURIComponent(name)] = Array(encodeURIComponent(value), true);
                }
            }

            Ajax.prototype.processURLString = function(string, encode) {
                var encoded = encodeURIComponent(this.argumentSeparator);
                var regexp = new RegExp(this.argumentSeparator + "|" + encoded);
                var varArray = string.split(regexp);
                for (var i = 0,len=varArray.length; i <len; i++){
                    var urlVars = varArray[i].split("=");
                    if (true == encode){
                        this.encVar(urlVars[0], urlVars[1]);
                    } else {
                        this.setVar(urlVars[0], urlVars[1]);
                    }
                }
            }

            Ajax.prototype.createURLString = function(urlstring) {
                if (this.encodeURIString && this.URLString.length) {
                    this.processURLString(this.URLString, true);
                }

                if (urlstring) {
                    if (this.URLString.length) {
                        this.URLString += this.argumentSeparator + urlstring;
                    } else {
                        this.URLString = urlstring;
                    }
                }

                // prevents caching of URLString
                this.setVar("rndval", new Date().getTime());

                var urlstringtemp = new Array();
                for (var key in this.vars) {
                    if (false == this.vars[key][1] && true == this.encodeURIString) {
                        var encoded = this.encVar(key, this.vars[key][0], true);
                        delete this.vars[key];
                        this.vars[encoded[0]] = Array(encoded[1], true);
                        key = encoded[0];
                    }
                    urlstringtemp[urlstringtemp.length] = key + "=" + this.vars[key][0];
                }
                if (urlstring){
                    this.URLString += this.argumentSeparator + urlstringtemp.join(this.argumentSeparator);
                } else {
                    this.URLString += urlstringtemp.join(this.argumentSeparator);
                }
            }

            Ajax.prototype.runResponse = function() {
                eval('('+this.response+')');
            }

            Ajax.prototype.runAJAX = function(urlstring) {
                if (this.failed) {
                    this.onFail();
                } else {
                    this.createURLString(urlstring);
                    if (this.element) {
                        this.elementObj = document.getElementById(this.element);
                    }
                    if (this.xhr) {
                        var _this = this;
                        // $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
                        // used by server to identify a Ajax request
                        this.xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                        if (this.method == "GET") {
                            var totalurlstring = this.requestFile + this.queryStringSeparator + this.URLString;
                            this.xhr.open(this.method, totalurlstring, true);
                        } else {
                            this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
                            this.xhr.open(this.method, this.requestFile, true);
                        }

                        this.xhr.onreadystatechange = function() {
                            switch (_this.xhr.readyState) {
                                case 1:
                                    _this.onLoading();
                                    break;
                                case 2:
                                    _this.onLoaded();
                                    break;
                                case 3:
                                    _this.onInteractive();
                                    break;
                                case 4:
                                    _this.response = _this.xhr.responseText;
                                    _this.responseXML = _this.xhr.responseXML;
                                    _this.responseStatus[0] = _this.xhr.status;
                                    _this.responseStatus[1] = _this.xhr.statusText;

                                    if (_this.execute) {
                                        _this.runResponse();
                                    }

                                    if (_this.elementObj) {
                                        elemNodeName = _this.elementObj.nodeName;
                                        elemNodeName.toLowerCase();
                                        if (elemNodeName == "input"
                                            || elemNodeName == "select"
                                            || elemNodeName == "option"
                                            || elemNodeName == "textarea") {
                                            _this.elementObj.value = _this.response;
                                        } else {
                                            _this.elementObj.innerHTML = _this.response;
                                        }
                                    }
                                    if (_this.responseStatus[0] == "200") {
                                        _this.onCompletion();
                                    } else {
                                        _this.onError();
                                    }

                                    _this.URLString = "";
                                    break;
                            }
                        };

                        this.xhr.send(this.URLString);
                    }
                }
            };
        }
        this.createXHR();
        alert(this.createXHR);
    } else {
        return new arguments.callee(file);
    }
}
