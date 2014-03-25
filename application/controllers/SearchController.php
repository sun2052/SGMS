<?php

class SearchController extends Controller {

    public function index() {
        $this->_model->requireAuthentication(STUDENT);
        $this->render('', $this->_model->index());
    }

}

