
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Eloquent</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Eloquent_Asplode" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Asplode.html">Asplode</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Eloquent_Asplode_Error" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Asplode/Error.html">Error</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Eloquent_Asplode_Error_AbstractErrorException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/AbstractErrorException.html">AbstractErrorException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Error_ErrorException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/ErrorException.html">ErrorException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Error_ErrorExceptionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/ErrorExceptionInterface.html">ErrorExceptionInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Error_FatalErrorException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/FatalErrorException.html">FatalErrorException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Error_FatalErrorExceptionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/FatalErrorExceptionInterface.html">FatalErrorExceptionInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Error_NonFatalErrorExceptionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Error/NonFatalErrorExceptionInterface.html">NonFatalErrorExceptionInterface</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Eloquent_Asplode_Exception" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Asplode/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Eloquent_Asplode_Exception_AlreadyInstalledException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Exception/AlreadyInstalledException.html">AlreadyInstalledException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Exception_AsplodeExceptionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Exception/AsplodeExceptionInterface.html">AsplodeExceptionInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Exception_ErrorHandlingConfigurationException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Exception/ErrorHandlingConfigurationException.html">ErrorHandlingConfigurationException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_Exception_NotInstalledException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/Exception/NotInstalledException.html">NotInstalledException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Eloquent_Asplode_HandlerStack" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Asplode/HandlerStack.html">HandlerStack</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Eloquent_Asplode_HandlerStack_AbstractHandlerStack" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html">AbstractHandlerStack</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_HandlerStack_ErrorHandlerStack" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html">ErrorHandlerStack</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_HandlerStack_ExceptionHandlerStack" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html">ExceptionHandlerStack</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_HandlerStack_HandlerStackInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Asplode/HandlerStack/HandlerStackInterface.html">HandlerStackInterface</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Eloquent_Asplode_Asplode" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Asplode/Asplode.html">Asplode</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_ErrorHandler" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Asplode/ErrorHandler.html">ErrorHandler</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_ErrorHandlerInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Asplode/ErrorHandlerInterface.html">ErrorHandlerInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_FatalErrorHandler" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Asplode/FatalErrorHandler.html">FatalErrorHandler</a>                    </div>                </li>                            <li data-name="class:Eloquent_Asplode_FatalErrorHandlerInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Asplode/FatalErrorHandlerInterface.html">FatalErrorHandlerInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Eloquent.html", "name": "Eloquent", "doc": "Namespace Eloquent"},{"type": "Namespace", "link": "Eloquent/Asplode.html", "name": "Eloquent\\Asplode", "doc": "Namespace Eloquent\\Asplode"},{"type": "Namespace", "link": "Eloquent/Asplode/Error.html", "name": "Eloquent\\Asplode\\Error", "doc": "Namespace Eloquent\\Asplode\\Error"},{"type": "Namespace", "link": "Eloquent/Asplode/Exception.html", "name": "Eloquent\\Asplode\\Exception", "doc": "Namespace Eloquent\\Asplode\\Exception"},{"type": "Namespace", "link": "Eloquent/Asplode/HandlerStack.html", "name": "Eloquent\\Asplode\\HandlerStack", "doc": "Namespace Eloquent\\Asplode\\HandlerStack"},
            {"type": "Interface", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html", "name": "Eloquent\\Asplode\\ErrorHandlerInterface", "doc": "&quot;The interface implemented by Asplode error handlers.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_setFallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::setFallbackHandler", "doc": "&quot;Set an error handler to use as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_fallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::fallbackHandler", "doc": "&quot;Get the error handler used as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_install", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::install", "doc": "&quot;Installs this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_uninstall", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::uninstall", "doc": "&quot;Uninstalls this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_isInstalled", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::isInstalled", "doc": "&quot;Returns true if this error handler is the top-most handler on the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_handle", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::handle", "doc": "&quot;Handles a PHP error.&quot;"},
            
            {"type": "Interface", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/ErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\ErrorExceptionInterface", "doc": "&quot;Interface used to identify all error exceptions.&quot;"},
                    
            {"type": "Interface", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/FatalErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\FatalErrorExceptionInterface", "doc": "&quot;Interface used to identify fatal error exceptions.&quot;"},
                    
            {"type": "Interface", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/NonFatalErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\NonFatalErrorExceptionInterface", "doc": "&quot;Interface used to identify non-fatal error exceptions.&quot;"},
                    
            {"type": "Interface", "fromName": "Eloquent\\Asplode\\Exception", "fromLink": "Eloquent/Asplode/Exception.html", "link": "Eloquent/Asplode/Exception/AsplodeExceptionInterface.html", "name": "Eloquent\\Asplode\\Exception\\AsplodeExceptionInterface", "doc": "&quot;Interface use to identify all Asplode-related exceptions, excluding actual\nerror exceptions.&quot;"},
                    
            {"type": "Interface", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "doc": "&quot;The interface implemented by fatal error handlers.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_install", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::install", "doc": "&quot;Installs this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_uninstall", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::uninstall", "doc": "&quot;Uninstalls this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_isInstalled", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::isInstalled", "doc": "&quot;Returns true if this fatal error handler is installed.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_handle", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::handle", "doc": "&quot;Handles PHP shutdown, and produces exceptions for any detected fatal\nerror.&quot;"},
            
            {"type": "Interface", "fromName": "Eloquent\\Asplode\\HandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "doc": "&quot;The interface implemented by handler stacks.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_handler", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::handler", "doc": "&quot;Gets the current handler without removing it from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_handlerStack", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::handlerStack", "doc": "&quot;Gets the current handler stack without changing the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_push", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::push", "doc": "&quot;Pushes a handler on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_pushAll", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::pushAll", "doc": "&quot;Pushes multiple handlers on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_pop", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::pop", "doc": "&quot;Pops a handler off the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_clear", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::clear", "doc": "&quot;Removes all handlers from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_restore", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::restore", "doc": "&quot;Restores a stack of handlers.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_executeWith", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::executeWith", "doc": "&quot;Temporarily bypass the current handler stack and execute a callable with\nthe supplied handler.&quot;"},
            
            
            {"type": "Class", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/Asplode.html", "name": "Eloquent\\Asplode\\Asplode", "doc": "&quot;Implements static convenience methods for use with Asplode.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\Asplode", "fromLink": "Eloquent/Asplode/Asplode.html", "link": "Eloquent/Asplode/Asplode.html#method_install", "name": "Eloquent\\Asplode\\Asplode::install", "doc": "&quot;Installs a new error handler, and a new fatal error handler\nsimultaneously.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\Asplode", "fromLink": "Eloquent/Asplode/Asplode.html", "link": "Eloquent/Asplode/Asplode.html#method_installErrorHandler", "name": "Eloquent\\Asplode\\Asplode::installErrorHandler", "doc": "&quot;Installs a new error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\Asplode", "fromLink": "Eloquent/Asplode/Asplode.html", "link": "Eloquent/Asplode/Asplode.html#method_installFatalHandler", "name": "Eloquent\\Asplode\\Asplode::installFatalHandler", "doc": "&quot;Installs a new fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\Asplode", "fromLink": "Eloquent/Asplode/Asplode.html", "link": "Eloquent/Asplode/Asplode.html#method_assertCompatibleHandler", "name": "Eloquent\\Asplode\\Asplode::assertCompatibleHandler", "doc": "&quot;Asserts that an error handling is configured in a way that is compatible\nwith code expecting error exceptions.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/ErrorHandler.html", "name": "Eloquent\\Asplode\\ErrorHandler", "doc": "&quot;The standard Asplode error handler.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method___construct", "name": "Eloquent\\Asplode\\ErrorHandler::__construct", "doc": "&quot;Construct a new error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_stack", "name": "Eloquent\\Asplode\\ErrorHandler::stack", "doc": "&quot;Get the error handler stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_setFallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandler::setFallbackHandler", "doc": "&quot;Set an error handler to use as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_fallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandler::fallbackHandler", "doc": "&quot;Get the error handler used as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_install", "name": "Eloquent\\Asplode\\ErrorHandler::install", "doc": "&quot;Installs this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_uninstall", "name": "Eloquent\\Asplode\\ErrorHandler::uninstall", "doc": "&quot;Uninstalls this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_isInstalled", "name": "Eloquent\\Asplode\\ErrorHandler::isInstalled", "doc": "&quot;Returns true if this error handler is the top-most handler on the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method_handle", "name": "Eloquent\\Asplode\\ErrorHandler::handle", "doc": "&quot;Handles a PHP error.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandler", "fromLink": "Eloquent/Asplode/ErrorHandler.html", "link": "Eloquent/Asplode/ErrorHandler.html#method___invoke", "name": "Eloquent\\Asplode\\ErrorHandler::__invoke", "doc": "&quot;Handles a PHP error.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html", "name": "Eloquent\\Asplode\\ErrorHandlerInterface", "doc": "&quot;The interface implemented by Asplode error handlers.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_setFallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::setFallbackHandler", "doc": "&quot;Set an error handler to use as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_fallbackHandler", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::fallbackHandler", "doc": "&quot;Get the error handler used as a fallback for errors that are not handled\nby Asplode.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_install", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::install", "doc": "&quot;Installs this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_uninstall", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::uninstall", "doc": "&quot;Uninstalls this error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_isInstalled", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::isInstalled", "doc": "&quot;Returns true if this error handler is the top-most handler on the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\ErrorHandlerInterface", "fromLink": "Eloquent/Asplode/ErrorHandlerInterface.html", "link": "Eloquent/Asplode/ErrorHandlerInterface.html#method_handle", "name": "Eloquent\\Asplode\\ErrorHandlerInterface::handle", "doc": "&quot;Handles a PHP error.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/AbstractErrorException.html", "name": "Eloquent\\Asplode\\Error\\AbstractErrorException", "doc": "&quot;An abstract base class for implementing extensions to the built-in error\nexception.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\Error\\AbstractErrorException", "fromLink": "Eloquent/Asplode/Error/AbstractErrorException.html", "link": "Eloquent/Asplode/Error/AbstractErrorException.html#method___construct", "name": "Eloquent\\Asplode\\Error\\AbstractErrorException::__construct", "doc": "&quot;Construct a new error exception.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/ErrorException.html", "name": "Eloquent\\Asplode\\Error\\ErrorException", "doc": "&quot;Represents a non-fatal error by extending the native error exception to mark\nit with appropriate interfaces.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/ErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\ErrorExceptionInterface", "doc": "&quot;Interface used to identify all error exceptions.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/FatalErrorException.html", "name": "Eloquent\\Asplode\\Error\\FatalErrorException", "doc": "&quot;Represents a fatal error by extending the native error exception to mark it\nwith appropriate interfaces.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/FatalErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\FatalErrorExceptionInterface", "doc": "&quot;Interface used to identify fatal error exceptions.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Error", "fromLink": "Eloquent/Asplode/Error.html", "link": "Eloquent/Asplode/Error/NonFatalErrorExceptionInterface.html", "name": "Eloquent\\Asplode\\Error\\NonFatalErrorExceptionInterface", "doc": "&quot;Interface used to identify non-fatal error exceptions.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Exception", "fromLink": "Eloquent/Asplode/Exception.html", "link": "Eloquent/Asplode/Exception/AlreadyInstalledException.html", "name": "Eloquent\\Asplode\\Exception\\AlreadyInstalledException", "doc": "&quot;This Asplode instance has already been installed.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\Exception\\AlreadyInstalledException", "fromLink": "Eloquent/Asplode/Exception/AlreadyInstalledException.html", "link": "Eloquent/Asplode/Exception/AlreadyInstalledException.html#method___construct", "name": "Eloquent\\Asplode\\Exception\\AlreadyInstalledException::__construct", "doc": "&quot;Construct a new already installed exception.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Exception", "fromLink": "Eloquent/Asplode/Exception.html", "link": "Eloquent/Asplode/Exception/AsplodeExceptionInterface.html", "name": "Eloquent\\Asplode\\Exception\\AsplodeExceptionInterface", "doc": "&quot;Interface use to identify all Asplode-related exceptions, excluding actual\nerror exceptions.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Exception", "fromLink": "Eloquent/Asplode/Exception.html", "link": "Eloquent/Asplode/Exception/ErrorHandlingConfigurationException.html", "name": "Eloquent\\Asplode\\Exception\\ErrorHandlingConfigurationException", "doc": "&quot;PHP&#039;s error handling is incorrectly configured.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\Exception\\ErrorHandlingConfigurationException", "fromLink": "Eloquent/Asplode/Exception/ErrorHandlingConfigurationException.html", "link": "Eloquent/Asplode/Exception/ErrorHandlingConfigurationException.html#method___construct", "name": "Eloquent\\Asplode\\Exception\\ErrorHandlingConfigurationException::__construct", "doc": "&quot;Construct a new error handling configuration exception.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\Exception", "fromLink": "Eloquent/Asplode/Exception.html", "link": "Eloquent/Asplode/Exception/NotInstalledException.html", "name": "Eloquent\\Asplode\\Exception\\NotInstalledException", "doc": "&quot;This Asplode instance has not been installed.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\Exception\\NotInstalledException", "fromLink": "Eloquent/Asplode/Exception/NotInstalledException.html", "link": "Eloquent/Asplode/Exception/NotInstalledException.html#method___construct", "name": "Eloquent\\Asplode\\Exception\\NotInstalledException::__construct", "doc": "&quot;Construct a new not installed exception.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/FatalErrorHandler.html", "name": "Eloquent\\Asplode\\FatalErrorHandler", "doc": "&quot;The standard Asplode fatal error handler.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method___construct", "name": "Eloquent\\Asplode\\FatalErrorHandler::__construct", "doc": "&quot;Construct a new fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method_stack", "name": "Eloquent\\Asplode\\FatalErrorHandler::stack", "doc": "&quot;Get the exception handler stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method_install", "name": "Eloquent\\Asplode\\FatalErrorHandler::install", "doc": "&quot;Installs this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method_uninstall", "name": "Eloquent\\Asplode\\FatalErrorHandler::uninstall", "doc": "&quot;Uninstalls this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method_isInstalled", "name": "Eloquent\\Asplode\\FatalErrorHandler::isInstalled", "doc": "&quot;Returns true if this fatal error handler is installed.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method_handle", "name": "Eloquent\\Asplode\\FatalErrorHandler::handle", "doc": "&quot;Handles PHP shutdown, and produces exceptions for any detected fatal\nerror.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandler", "fromLink": "Eloquent/Asplode/FatalErrorHandler.html", "link": "Eloquent/Asplode/FatalErrorHandler.html#method___invoke", "name": "Eloquent\\Asplode\\FatalErrorHandler::__invoke", "doc": "&quot;Handles PHP shutdown, and produces exceptions for any detected fatal\nerror.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode", "fromLink": "Eloquent/Asplode.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "doc": "&quot;The interface implemented by fatal error handlers.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_install", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::install", "doc": "&quot;Installs this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_uninstall", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::uninstall", "doc": "&quot;Uninstalls this fatal error handler.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_isInstalled", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::isInstalled", "doc": "&quot;Returns true if this fatal error handler is installed.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\FatalErrorHandlerInterface", "fromLink": "Eloquent/Asplode/FatalErrorHandlerInterface.html", "link": "Eloquent/Asplode/FatalErrorHandlerInterface.html#method_handle", "name": "Eloquent\\Asplode\\FatalErrorHandlerInterface::handle", "doc": "&quot;Handles PHP shutdown, and produces exceptions for any detected fatal\nerror.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\HandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "doc": "&quot;An abstract base class for implementing handler stacks.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method___construct", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::__construct", "doc": "&quot;Construct a new handler stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_handler", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::handler", "doc": "&quot;Gets the current handler without removing it from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_handlerStack", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::handlerStack", "doc": "&quot;Gets the current handler stack without changing the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_pushAll", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::pushAll", "doc": "&quot;Pushes multiple handlers on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_clear", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::clear", "doc": "&quot;Removes all handlers from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_restore", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::restore", "doc": "&quot;Restores a stack of handlers.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/AbstractHandlerStack.html#method_executeWith", "name": "Eloquent\\Asplode\\HandlerStack\\AbstractHandlerStack::executeWith", "doc": "&quot;Temporarily bypass the current handler stack and execute a callable with\nthe supplied handler.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\HandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html", "name": "Eloquent\\Asplode\\HandlerStack\\ErrorHandlerStack", "doc": "&quot;Manages the PHP error handler stack.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\ErrorHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html#method_push", "name": "Eloquent\\Asplode\\HandlerStack\\ErrorHandlerStack::push", "doc": "&quot;Pushes a handler on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\ErrorHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html#method_pop", "name": "Eloquent\\Asplode\\HandlerStack\\ErrorHandlerStack::pop", "doc": "&quot;Pops a handler off the stack.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\HandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html", "name": "Eloquent\\Asplode\\HandlerStack\\ExceptionHandlerStack", "doc": "&quot;Manages the PHP exception handler stack.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\ExceptionHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html#method_push", "name": "Eloquent\\Asplode\\HandlerStack\\ExceptionHandlerStack::push", "doc": "&quot;Pushes a handler on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\ExceptionHandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html#method_pop", "name": "Eloquent\\Asplode\\HandlerStack\\ExceptionHandlerStack::pop", "doc": "&quot;Pops a handler off the stack.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Asplode\\HandlerStack", "fromLink": "Eloquent/Asplode/HandlerStack.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "doc": "&quot;The interface implemented by handler stacks.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_handler", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::handler", "doc": "&quot;Gets the current handler without removing it from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_handlerStack", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::handlerStack", "doc": "&quot;Gets the current handler stack without changing the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_push", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::push", "doc": "&quot;Pushes a handler on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_pushAll", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::pushAll", "doc": "&quot;Pushes multiple handlers on to the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_pop", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::pop", "doc": "&quot;Pops a handler off the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_clear", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::clear", "doc": "&quot;Removes all handlers from the stack.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_restore", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::restore", "doc": "&quot;Restores a stack of handlers.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface", "fromLink": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html", "link": "Eloquent/Asplode/HandlerStack/HandlerStackInterface.html#method_executeWith", "name": "Eloquent\\Asplode\\HandlerStack\\HandlerStackInterface::executeWith", "doc": "&quot;Temporarily bypass the current handler stack and execute a callable with\nthe supplied handler.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


