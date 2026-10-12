<?php
// Prevent Usercentrics (and other CMPs) from blocking Gravity Forms scripts.
// Uses data-uc-disable-processing="true" — UC's documented Smart Data Protector
// exclusion attribute — so no UC admin service configuration is required.
add_filter('script_loader_tag', function ($tag, $handle) {
    $gf_handles = [
        'jquery',
        'jquery-core',
        'jquery-migrate',
        'gform_json',
        'gform_gravityforms',
        'gform_gravityforms-js-extra',
        'gform_gravityforms-js-before',
        'gform_conditional_logic',
        'gform_conditional_logic-js-extra',
        'gform_gravityforms_utils',
        'gforms_recaptcha_recaptcha', // Google reCAPTCHA API script
        'gforms_recaptcha_recaptcha-js-extra',
        'gforms_recaptcha_frontend',
        'gforms_recaptcha_frontend-js',
        'gforms_event_tracking_utm_gtm',
        'gforms_event_tracking_utm_gtm-js',
        'gform_masked_input',
        'gform_masked_input-js',
        'gform_placeholder',
        'gform_placeholder-js',
        'gform_gravityforms_theme_vendors',
        'gform_gravityforms_theme_vendors-js',
        'gform_gravityforms_theme-js-extra',
        'gform_gravityforms_theme',
        'gform_gravityforms_theme-js',
    ];
    if (in_array($handle, $gf_handles)) {
        // Strip any type="text/plain" added by CMP plugins at PHP level.
        $tag = preg_replace('/\s+type=["\'](text\/plain)["\']/', '', $tag);
        // Remove any data-usercentrics attribute we may have added previously
        $tag = preg_replace('/\s+data-usercentrics=["\'][^"\']*["\']/', '', $tag);
        if (strpos($tag, 'data-uc-disable-processing') === false) {
            $tag = str_replace('<script ', '<script data-uc-disable-processing="true" ', $tag);
        }
        // Tell Flying Press not to delay these scripts.
        if (strpos($tag, 'data-loading-method') === false) {
            $tag = str_replace('<script ', '<script data-loading-method="direct" ', $tag);
        }
        $tag = preg_replace('/\s+defer(?:=["\']defer["\'])?(?=[\s>\/]|$)/i', '', $tag);
    }
    return $tag;
}, 10, 2);

add_filter('wp_inline_script_attributes', function ($attributes, $data) {
    if (
        strpos($data, 'gform_theme_config') !== false ||
        strpos($data, 'gforms_recaptcha_recaptcha_strings') !== false ||
        strpos($data, 'gform.initializeOnLoaded') !== false ||
        strpos($data, 'gform = {') !== false ||
        strpos($data, 'window.gform=') !== false ||
        strpos($data, 'window.gform =') !== false
    ) {
        // UC exclusion attribute for inline scripts.
        $attributes['data-uc-disable-processing'] = 'true';
        // Tell Flying Press not to delay these inline scripts either.
        $attributes['data-loading-method'] = 'direct';
        unset($attributes['data-usercentrics']);
    }

    return $attributes;
}, 10, 2);

// Early window.grecaptcha interceptor injected into <head> before any CMP or reCAPTCHA API script.
add_action('wp_head', function () {
    $script = <<<'RCJS'
(function(){
var rq=[],xq=[],adopted=false;
function isReal(v){return !!v&&typeof v.ready==='function'&&typeof v.execute==='function'&&!v.execute._gf;}
function stubReady(cb){rq.push(cb);check();}
stubReady._gf=1;
function stubExec(k,o){return new Promise(function(res,rej){xq.push([k,o,res,rej]);check();});}
stubExec._gf=1;
function flush(v){
adopted=true;
rq.splice(0).forEach(function(cb){try{v.ready._gf?cb():v.ready(cb);}catch(e){}});
xq.splice(0).forEach(function(e){try{var run=function(){v.execute(e[0],e[1]).then(e[2],e[3]);};v.ready._gf?run():v.ready(run);}catch(x){try{e[3](x);}catch(z){}}});
}
function check(){if(adopted)return;var g=window.grecaptcha;if(isReal(g))flush(g);}
var store=window.grecaptcha;
if(isReal(store)){adopted=true;}
else{
if(!store||typeof store!=='object'){store={};}
if(typeof store.ready!=='function'){store.ready=stubReady;}
if(typeof store.execute!=='function'){store.execute=stubExec;}
}
try{Object.defineProperty(window,'grecaptcha',{configurable:true,enumerable:true,
get:function(){return store;},
set:function(n){
if(n&&typeof n==='object'&&!isReal(n)){
if(typeof n.ready!=='function'){n.ready=stubReady;}
if(typeof n.execute!=='function'){n.execute=stubExec;}
}
store=n;
if(isReal(n))flush(n);
}});}catch(e){}
var iv=setInterval(function(){if(adopted){clearInterval(iv);return;}var g=window.grecaptcha;if(isReal(g)){flush(g);clearInterval(iv);}},50);
})();
RCJS;
    echo '<script id="gf-rc-intercept" data-loading-method="direct" data-uc-disable-processing="true">' . $script . '</script>' . "\n";
}, 1);
?>