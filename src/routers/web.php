<?php

use App\Controllers\ContactController;

$app->group('/api', function(){

    $this->group('/contact', function(){
        $this->get('/all', ContactController::class.':all');
        $this->get('/{id}', ContactController::class.':show');
        $this->post('/create',  ContactController::class.':create');
        $this->put('/edit/{id}',  ContactController::class.':edit');
        $this->delete('/delete/{id}',  ContactController::class.':delete');
    });
});

