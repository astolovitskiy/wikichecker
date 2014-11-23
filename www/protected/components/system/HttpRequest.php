<?php

class HttpRequest extends CHttpRequest {

	public function getJsonParams() {
		return CJSON::decode(file_get_contents('php://input'));
	}
}