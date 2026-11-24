<?php
class ErrorController extends Controller
{
    public function notFound(): void { $this->abort(404); }
    public function forbidden(): void { $this->abort(403); }
}
