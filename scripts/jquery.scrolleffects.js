/*
 Copyright 2011-2016 Adobe Systems Incorporated. All Rights Reserved.
*/
(function(a){var b=a(window),c=function(a,b,c,f){this.service=a;this.$bp=b;this.elem=c;this.data=f;this.cssProxy=this.service.cssProxy;this.enabled=f&&0<f.length;this.visible=!0;this.isMarkedAsOOV=!1};c.HIDDEN_CLASS="mse_pre_init";c.prototype.onBPActivate=function(){};c.prototype.onBPDeactivate=function(){this.hasPreInitClass=!0;this.elem.addClass(c.HIDDEN_CLASS)};c.prototype.clone=function(a){a.hasClass(c.HIDDEN_CLASS)||a.addClass(c.HIDDEN_CLASS);a.registerGenericScrollEffect(c,this.data)};c.prototype.initialize=
function(){this.hasPreInitClass=this.elem.hasClass(c.HIDDEN_CLASS);var b=a("#page"),f=Muse.Utils.tryParse(a("body").css("padding-top"),parseInt,0)+Muse.Utils.tryParse(b.css("border-top-width"),parseInt,0);this.initialPosition={left:Muse.Utils.tryParse(this.elem.css("left"),parseInt,0)+Muse.Utils.tryParse(b.css("border-left-width"),parseInt,0),top:Muse.Utils.tryParse(this.elem.css("top"),parseInt,0)+f};this.referenceOffset=this.data[0]["in"][1];this.elemWidth=this.elem.innerWidth();this.elemHeight=
this.elem.innerHeight();this.skipVisibleCheck=this.elemWidth<1;for(var d,b=0;f=this.data[b];b++)f.length=f["in"][1]-f["in"][0],f.startPosition=d?{left:d.startPosition.left+d.length*d.speed[0],top:d.startPosition.top+d.length*d.speed[1]}:{left:-f.length*f.speed[0],top:-f.length*f.speed[1]},d=f};c.prototype.update=function(b,f,d){if(!a("body").hasClass("awaiting_bp_activate_scroll")){var g=this.initialPosition.left-d.scrollLeft,h=this.initialPosition.top-this.referenceOffset,j=b.startPosition.left+
b.speed[0]*f,f=b.startPosition.top+b.speed[1]*f,k={};if("number"==typeof b.speed[0])k.left=g+j+"px";if("number"==typeof b.speed[1])k.top=h-f+"px";if(this.visible=this.skipVisibleCheck||this.getVisible(g+j,h-f,d)){if(this.isMarkedAsOOV)k.display="",this.isMarkedAsOOV=!1;this.cssProxy.setCSSProperties(this.elem,k)}else if(!this.isMarkedAsOOV)this.cssProxy.setCSSProperties(this.elem,{display:"none"}),this.isMarkedAsOOV=!0;if(this.hasPreInitClass)this.elem.removeClass(c.HIDDEN_CLASS),this.hasPreInitClass=
!1}};c.prototype.getVisible=function(a,b,c){var f=Math.max(this.elemWidth,this.elemHeight)+100;return(void 0===a||a+f>0&&a-f<c.windowWidth)&&(void 0===b||b+f>0&&b-f<c.windowHeight)};var d=function(a,b,c,f){this.service=a;this.$bp=b;this.elem=c;this.data=f;this.cssProxy=this.service.cssProxy;this.r7Mode=!0;if(!this.r7Mode&&(this.cssBackgroundPosition=this.elem.css("background-position"),this.cssBackgroundPosition.match(/^\d+\%$/gi)))this.cssBackgroundPosition=(a=this.elem[0].currentStyle)&&a.backgroundPositionX&&
a.backgroundPositionY?a.backgroundPositionX+" "+a.backgroundPositionY:Muse.Utils.getRuleProperty(this.getCSSRules(),"background-position");if(this.useBackgroundFixedOptimization()){this.elem.css("background-attachment","fixed");if(this.r7Mode)this.enabled=!1;this.backgroundFixedMode=!0}this.elem.data("hasBackgroundPositionScrollEffect",!0)};d.BG_NORMAL=0;d.BG_COVER=1;d.BG_CONTAIN=2;d.prototype.getCSSRules=function(){if(!this.pageSheet)this.pageStyleSheet=Muse.Utils.getPageStyleSheets();if(!this.cssRules)this.cssRules=
Muse.Utils.getStyleSheetRulesById(this.pageStyleSheet,this.elem.attr("id"));return this.cssRules};d.prototype.useBackgroundFixedOptimization=function(){if(!b.data("scrollWrapper").isStandard())return!1;return 0==this.data[0].speed[0]&&0==this.data[0].speed[1]&&0==this.data[1].speed[0]&&0==this.data[1].speed[1]};d.prototype.initialize=function(){this.referenceOffset=this.data[0]["in"][1];var f=this.elem.parent();this.is100PercentWidth=f.hasClass("browser_width");this.hasPositionEffect=(this.positionEffect=
this.service.getElementEffect(this.is100PercentWidth?f:this.elem,c))&&this.positionEffect.enabled;for(var f=0,d,g;d=this.data[f];f++)d.speed[0]-=0,d.speed[1]-=1,d.length=d["in"][1]-d["in"][0],d.startPosition=null==g?{left:-d.length*d.speed[0],top:-d.length*d.speed[1]}:{left:g.startPosition.left+g.length*g.speed[0],top:g.startPosition.top+g.length*g.speed[1]},g=d;if(!Muse.Browser.Features.checkCSSFeature("background-size")&&this.elem.hasClass("museBGSize")&&0<a("> .museBgSizePolyfill",this.elem).length)this.polyfillElement=
a(a(".museBgSizePolyfill img",this.elem)[0]);this.bgMode=this.getBgMode();this.backgroundOffsetAvailable=!1;this.elem.resize(this,this.onElementResize);this.is100PercentWidth&&b.resize(this,this.onWindowResize);this.backgroundPosition=this.getBackgroundPosition();this.getBackgroundOffset();if(this.elem.hasClass("browser_width"))this.originalWidth=Muse.Utils.tryParse(Muse.Utils.getRuleProperty(this.getCSSRules(),"width"),parseInt)};d.prototype.onWindowResize=function(a){a.data.recalculateBackgroundOffset=
!0};d.prototype.onElementResize=function(a){var a=a.data,b=a.service.getEffectProgress(),c=a.service.getEffectInterval(a,b);a.update(c,b-c["in"][0])};d.prototype.hasOriginalWidth=function(){return Muse.Utils.isDefined(this.originalWidth)&&-1!=this.originalWidth};d.prototype.getDeltaWidth=function(){if(!this.hasOriginalWidth())return 0;return(this.elem.innerWidth()-this.originalWidth)*this.backgroundPosition.multiplier.x};d.prototype.getBackgroundModeDisplayRatio=function(){switch(this.bgMode){case d.BG_CONTAIN:return Math.min(this.elem.innerWidth()/
this.backgroundSize.width,this.elem.innerHeight()/this.backgroundSize.height);case d.BG_COVER:return Math.max(this.elem.innerWidth()/this.backgroundSize.width,this.elem.innerHeight()/this.backgroundSize.height);default:return 1}};d.prototype.updateFixedBackground=function(a,b){var c=this.getBackgroundModeDisplayRatio(),f=this.elem.offset(),g=f.left,h=f.top-this.referenceOffset;if(this.hasPositionEffect&&0==this.positionEffect.data[this.data.indexOf(a)].speed[1]||!this.hasPositionEffect&&"fixed"==
this.elem.css("position"))h=f.top-(a["in"][0]+b);f=(d.BG_COVER!==this.bgMode||!this.is100PercentWidth?g:0)+this.backgroundPosition.multiplier.x*(this.elem.width()-c*this.backgroundSize.width)+Muse.Utils.getCSSIntValue(this.elem,"border-left-width");h=h+this.backgroundPosition.multiplier.y*(this.elem.height()-c*this.backgroundSize.height)+Muse.Utils.getCSSIntValue(this.elem,"border-top-width");h={"background-position":f+"px "+h+"px"};1!=c&&(h["background-size"]=c*this.backgroundSize.width+"px "+c*
this.backgroundSize.height+"px");this.cssProxy.setCSSProperties(this.elem,h)};d.prototype.update=function(a,b){if(this.backgroundOffsetAvailable){if(this.recalculateBackgroundOffset)this.recalculateBackgroundOffset=!1,this.getBackgroundOffset();if(this.backgroundFixedMode)this.updateFixedBackground(a,b);else{var c=this.getBackgroundModeDisplayRatio()-1,f=Math.floor(this.bgOffset.x-c*this.backgroundPosition.multiplier.x*this.backgroundSize.width+this.getDeltaWidth())+a.startPosition.left+a.speed[0]*
b,c=Math.floor(this.bgOffset.y-c*this.backgroundPosition.multiplier.y*this.backgroundSize.height)-(a.startPosition.top+a.speed[1]*b);this.polyfillElement?(f={"margin-left":f+"px","margin-top":c+"px",left:0,top:0},this.cssProxy.setCSSProperties(this.polyfillElement,f)):(f={"background-attachment":"scroll","background-position":f+"px "+c+"px"},this.cssProxy.setCSSProperties(this.elem,f))}}else this.updateRequested=!0};d.prototype.getBackgroundOffset=function(){var a=Muse.Utils.tryParse(this.backgroundPosition.x,
parseFloat,0),b=Muse.Utils.tryParse(this.backgroundPosition.y,parseFloat,0);if(!Muse.Utils.endsWith(this.backgroundPosition.x,"%")&&!Muse.Utils.endsWith(this.backgroundPosition.y,"%"))this.onBackgroundOffsetAvailable(a,b);else if(this.backgroundSize)this.updateBackgroundOffset(a,b);else{var c=this;this.getBackgroundSize(function(f){c.backgroundSize=f;c.updateBackgroundOffset(a,b);if(c.updateRequested){c.updateRequested=!1;var f=c.service.getEffectProgress(),d=c.service.getEffectInterval(c,f);c.update(d,
f-d["in"][0])}})}};d.prototype.updateBackgroundOffset=function(a,b){var c=this.is100PercentWidth&&this.hasPositionEffect&&this.positionEffect.isMarkedAsOOV?this.elem.parent():this.elem;if(Muse.Utils.endsWith(this.backgroundPosition.x,"%"))var f=Muse.Utils.firstDefined(this.originalWidth,c.innerWidth()),a=a/100*(f-Muse.Utils.firstDefined(this.backgroundSize.width,f));Muse.Utils.endsWith(this.backgroundPosition.y,"%")&&(c=c.innerHeight(),b=b/100*(c-Muse.Utils.firstDefined(this.backgroundSize.height,
c)));this.onBackgroundOffsetAvailable(a,b)};d.prototype.onBackgroundOffsetAvailable=function(a,b){this.bgOffset={x:a,y:b};this.backgroundOffsetAvailable=!0};d.prototype.getBgMode=function(){var a=(this.elem.get(0).currentStyle||window.getComputedStyle(this.elem.get(0),null))["background-size"]||this.elem.css("background-size");if(!a||!a.match)return d.BG_NORMAL;if(a.match(/cover/gi))return d.BG_COVER;if(a.match(/contain/))return d.BG_CONTAIN;return d.BG_NORMAL};d.prototype.isValidBackgroundPosition=
function(a){return Muse.Utils.endsWith(a,"%")||Muse.Utils.endsWith(a,"px")};d.prototype.getBackgroundPosition=function(){var a=this.cssBackgroundPosition?this.cssBackgroundPosition:this.elem.css("background-position");switch(a){case "top":case "bottom":a="center "+a;break;case "0%":case "50%":case "100%":a+=" center"}if(!a){var b=this.elem.css("background-position-x"),c=this.elem.css("background-position-y");b&&(a=b+" "+(c||""))}if(!a||!a.split)return{x:"0%",y:"0%"};a=a.replace(/(?:left|top)/gi,"0%").replace(/center/gi,
"50%").replace(/(?:right|bottom)/gi,"100%");a=a.replace(/^\s+|\s+$/gi,"");a=a.split(" ");1==a.length&&a.push("50%");if(!this.isValidBackgroundPosition(a[0])||!this.isValidBackgroundPosition(a[1]))Muse.Assert.fail("Invalid measurement unit for background position. Expecting px or %.");else return{x:a[0],y:a[1],multiplier:{x:Muse.Utils.endsWith(a[0],"%")?Muse.Utils.tryParse(a[0],parseInt,0)/100:0,y:Muse.Utils.endsWith(a[1],"%")?Muse.Utils.tryParse(a[1],parseInt,0)/100:0}}};d.prototype.getBackgroundSize=
function(b){var c=this.polyfillElement?this.polyfillElement.attr("src"):this.elem.css("background-image");if(!c&&!c.replace)b();else{var c=c.replace(/^url\("?|"?\)$/gi,""),f=new Image;a(f).one("load",function(){b({width:f.width,height:f.height})});f.src=c}};var g=function(a,b,c,f){this.service=a;this.$bp=b;this.elem=c;this.data=f};g.prototype.initialize=function(){};g.prototype.update=function(){};var f=function(a,b,c,d){this.service=a;this.$bp=b;this.elem=c;this.data=d;this.cssProxy=this.service.cssProxy;
this.elemToBeMarkedAsInvisible=this.elem.parent().hasClass("browser_width")?this.elem.parent():this.elem;this.hasPreInitClass=this.elem.hasClass(f.PRE_INITIT_CLASS_NAME)};f.PRE_INITIT_CLASS_NAME="ose_pre_init";f.INVISIBLE_CLASS_NAME="ose_ei";f.prototype.initialize=function(){Muse.Assert.assert(3==this.data.length,"Opacity Scroll Effect should have 3 intervals");var a=this.data[0],b=this.data[1],f=this.data[2];0<a.fade&&(a["in"][1]-=a.fade,this.data.splice(1,0,{"in":[a["in"][1],a["in"][1]+a.fade],
opacity:[a.opacity,b.opacity],rate:(b.opacity-a.opacity)/a.fade}));0<f.fade&&(f["in"][0]+=f.fade,this.data.splice(this.data.length-1,0,{"in":[f["in"][0]-f.fade,f["in"][0]],opacity:[b.opacity,f.opacity],rate:(f.opacity-b.opacity)/f.fade}));this.hasPositionEffect=(this.positionEffect=this.service.getElementEffect(this.elem,c))&&this.positionEffect.enabled};f.prototype.setElementOpacity=function(a){this.cssProxy.setCSSProperties(this.elem,{opacity:a/100,filter:"alpha(opacity="+a+")"});var b=0===a;if(void 0===
this.previousOpacity||b&&0!==this.previousOpacity||!b&&0===this.previousOpacity)b?this.elemToBeMarkedAsInvisible.addClass(f.INVISIBLE_CLASS_NAME):this.elemToBeMarkedAsInvisible.removeClass(f.INVISIBLE_CLASS_NAME);this.previousOpacity=a};f.prototype.update=function(a,b){var c=0;if(!this.hasPositionEffect||this.positionEffect.visible)c="number"!=typeof a.opacity?a.opacity[0]+a.rate*b:a.opacity,c=Math.max(Math.min(c,100),0);this.setElementOpacity(c);if(this.hasPreInitClass)this.elem.removeClass(f.PRE_INITIT_CLASS_NAME),
this.hasPreInitClass=!1};var j=function(a,b,c,f){this.service=a;this.$bp=b;this.elem=c;this.data=f;this.widget=this.elem.data("widget");this.lastDisplayedSlide=0;this.lastInterval=null};j.prototype.initialize=function(){this.noOfSlides=this.widget.slides.$element.length;if(this.isLinkToScrollEffect=this.isLinkToScrollInterval(this.data[1]))this.data[1].intervalLength=this.data[1]["in"][1]-this.data[1]["in"][0],Muse.Assert.assert(2==this.data.length||Infinity!=this.data[1].intervalLength,"In a 3 interval configuration, why do we have middle interval with length = Infinity?")};
j.prototype.update=function(a,b){if(this.play!==a.play)!0===a.play?(this.play=!0,this.start()):!1===a.play?(this.play=!1,this.stop()):this.isLinkToScrollInterval(a)?(this.play=void 0,this.jump(b)):Muse.Assert.assert(!1,"Unknown widget configuration: play="+a.play);if(!1===a.play&&this.isLinkToScrollEffect&&a!==this.lastInterval)switch(this.data.indexOf(a)){case 0:this.jump(0);break;case 2:this.jump(this.data[1].intervalLength);break;default:Muse.Assert.assert(!1,"Why is the second interval using a play:false setting?")}this.lastInterval=
a};j.prototype.isLinkToScrollInterval=function(a){return"number"==typeof a.play};j.prototype.jump=function(a){var a=Math.floor(a/this.data[1].play),b=(a-this.lastDisplayedSlide)%this.noOfSlides;if(0!=b){for(var c=0<b?b:-b,f=0;f<c;f++)0<b?this.widget.next():this.widget.previous();this.lastDisplayedSlide=a}};j.prototype.start=function(){var b;a(this.widget).one("wp-slideshow-before-play",function(){b=this.options.displayInterval;this.options.displayInterval=0});a(this.widget).one("wp-slideshow-play",
function(){Muse.Assert.assert(void 0!==b,"Why do we got a play event fired before beforePlay event?");this.options.displayInterval=b});this.widget.play()};j.prototype.stop=function(){this.widget.stop()};var h=function(a,b,c,f){this.service=a;this.$bp=b;this.elem=c;this.data=f;this.enabled=!0;this.stage=null;this.play=!1;this.lastInterval=null};h.prototype.initialize=function(){this.data[1].intervalLength=this.data[1]["in"][1]-this.data[1]["in"][0];Muse.Assert.assert(2==this.data.length||Infinity!=
this.data[1].intervalLength,"In a 3 interval configuration, why do we have middle interval with length = Infinity?");this.iframe=this.elem.children()[0];this.iframeWindow=this.iframe.contentWindow;if(this.iframeWindow.AdobeEdge)this.updateStage(this);else{var b=this;a(this.iframe).bind("load",function(){b.updateStage(b)})}};h.prototype.updateStage=function(a){"undefined"==typeof a.iframeWindow.AdobeEdge?a.enabled=!1:a.iframeWindow.AdobeEdge.bootstrapCallback(function(b){a.onCompositionReady(b,a)})};
h.prototype.onCompositionReady=function(a,b){var c=b.iframeWindow.AdobeEdge,f=null;Muse.Assert.assert(null!=c,"AdobeEdge object must not be null.");"undefined"!=typeof c.compositions?f=c.compositions[a]:"function"==typeof c.getComposition?f=c.getComposition(a):Muse.Assert.assert(!1,"Could not find any reliable way of obtaining the composition object.");Muse.Assert.assert(null!=f,"Composition object must not be null.");b.stage=f.getStage();if(b.stage&&"function"==typeof b.stage.setAutoPlay)b.stage.setAutoPlay(!1);
else for(var d in b.stage.timelines)b.stage.autoPlay[d]=!1;b.lastUpdateInterval&&b.lastUpdateIntervalProgress&&setTimeout(function(){b.update(b.lastUpdateInterval,b.lastUpdateIntervalProgress)},10)};h.prototype.update=function(a,b){if(this.enabled)if(this.stage){if(this.play!==a.play)!0===a.play?(this.play=!0,this.start()):!1===a.play?(this.play=!1,this.stop()):"number"==typeof a.play?(this.play=!0,this.seek(b*1E3/a.play)):Muse.Assert.assert(!1,"Unknown widget configuration: play="+a.play);if(!1===
a.play&&a!==this.lastInterval)switch(this.data.indexOf(a)){case 0:this.seek(0);break;case 2:this.seek(this.data[1].intervalLength*1E3/this.data[1].play);break;default:Muse.Assert.assert(!1,"Why is the second interval using a play:false setting?")}this.lastInterval=a}else this.lastUpdateInterval=a,this.lastUpdateIntervalProgress=b};h.prototype.start=function(){this.stage.play()};h.prototype.stop=function(){this.stage.stop(this.stage.getTimelinePosition())};h.prototype.seek=function(a){this.stage.seek(a%
this.stage.getDuration())};var i=function(a){this.idGetterFn=a;this.mode=i.MODE_IMMEDIATE;this.cssPropsCache={};this.requestCSSUpdatePending=!1};i.MODE_IMMEDIATE=0;i.MODE_DELAYED=1;i.prototype.setModeDelayed=function(){if(window.webkitRequestAnimationFrame)this.mode=i.MODE_DELAYED};i.prototype.clearCacheForElement=function(a){this.getCacheForElement(a).appliedProps={}};i.prototype.getCacheForElement=function(a){var b=this.idGetterFn(a),c=this.cssPropsCache[b];void 0===c&&(this.cssPropsCache[b]=c=
{style:a[0].style,appliedProps:{},queuedProps:{},hasQueuedProps:!1});return c};i.prototype.setCSSProperties=function(a,b){var c=this.getCacheForElement(a),f=!1,d=this,g;for(g in b)if(c.appliedProps[g]!==b[g])c.queuedProps[g]=b[g],c.hasQueuedProps=f=!0;if(!this.requestCSSUpdatePending&&f)this.requestCSSUpdatePending=!0,i.MODE_DELAYED==this.mode?Muse.Utils.requestAnimationFrame(function(){d.doCSSUpdate()}):this.doCSSUpdate()};i.prototype.doCSSUpdate=function(){for(var a in this.cssPropsCache){var b=
this.cssPropsCache[a];if(b.hasQueuedProps){for(var c in b.queuedProps)b.style[Muse.Utils.toCamelCase(c)]=b.appliedProps[c]=b.queuedProps[c];b.queuedProps={};b.hasQueuedProps=!1}}this.requestCSSUpdatePending=!1};var k=function(){this.effects=[];this.scrollY=this.scrollX=0;this.$page=a("#page");this.cssProxy=new i(this.getElemID);var b=this;a("body").on("muse_bp_activate",function(a,c,f){b.onBPActivate(f)}).on("muse_bp_deactivate",function(a,c,f){b.onBPDeactivate(f)})};k.TEMP_UID_ATTR="data-muse-tempuid";
k.prototype.onBPActivate=function(b){this.$page=a("#page");for(var c=0;c<this.effects.length;c++)if(this.effects[c].$bp.is(b)&&this.effects[c].onBPActivate)this.effects[c].onBPActivate()};k.prototype.onBPDeactivate=function(a){for(var b=0;b<this.effects.length;b++)if(this.effects[b].$bp.is(a)){if(this.effects[b].onBPDeactivate)this.effects[b].onBPDeactivate();var c=this.effects[b].elem;c.removeAttr("style");this.cssProxy.clearCacheForElement(c)}};k.prototype.getEffectProgress=function(){return Math.max(0,
this.scrollY)};k.prototype.getHorizontalScroll=function(){return this.scrollX-this.$page.offset().left};k.prototype.getEnvironmentSettings=function(){return{windowWidth:window.innerWidth||b.width(),windowHeight:window.innerHeight||b.height(),scrollLeft:this.getHorizontalScroll(),$activeBP:a(".breakpoint.active")}};k.prototype.onUpdate=function(a,b){this.scrollX=a;this.scrollY=b;for(var c=this.getEnvironmentSettings(),f=0;f<this.effects.length;f++)this.doUpdateOneEffect(this.effects[f],c)};k.prototype.doUpdateOneEffect=
function(a,b){if(!a.$bp||a.$bp.is(b.$activeBP)){var c=this.getEffectProgress(),f=this.getEffectInterval(a,c);if(!a.initialized)a.initialize(),a.initialized=!0,a.elem.addClass("scroll_effect");a.update(f,c-f["in"][0],b)}};k.prototype.getEffectInterval=function(a,b){for(var c=0,f;f=a.data[c]["in"];c++)if(f[0]<b&&b<=f[1])return a.data[c];Muse.Assert.fail("Why do we have a progress value that does not fit in any interval?");return null};k.prototype.registerEffect=function(a,b,c,f){var d=this,g=new c(this,
a,b,f);if(!1!==g.enabled)g.type=c,g.data[0]["in"][0]=-100,(!a||a.hasClass("active"))&&setTimeout(function(){d.doUpdateOneEffect(g,d.getEnvironmentSettings())},0),this.effects.push(g)};k.prototype.getElementEffect=function(a,b){for(var c=m.effects.length,f=0;f<c;f++){var d=m.effects[f];if(d.elem.is(a)&&d.type==b)return d}};k.prototype.getElemID=function(a){var b=a.attr("id")||a.attr(k.TEMP_UID_ATTR)||a.attr(k.TEMP_UID_ATTR,Math.round(Math.random()*1E6)).attr(k.TEMP_UID_ATTR),a=a.closest(".breakpoint");
0<a.length&&(b=a.attr("id")+"_"+b);return b};var m=new k;b.data("scrollEffectsService",m);a.fn.registerPositionScrollEffect=function(b,f){return a(this).registerGenericScrollEffect(c,b,f)};a.fn.registerBackgroundPositionScrollEffect=function(b,c){return a(this).registerGenericScrollEffect(d,b,c)};a.fn.registerRotateScrollEffect=function(b,c){return a(this).registerGenericScrollEffect(g,b,c)};a.fn.registerOpacityScrollEffect=function(b,c){return a(this).registerGenericScrollEffect(f,b,c)};a.fn.registerSlideshowScrollEffect=
function(b,c){return a(this).registerGenericScrollEffect(j,b,c)};a.fn.registerEdgeAnimateScrollEffect=function(b,c){return a(this).registerGenericScrollEffect(h,b,c)};a.fn.registerGenericScrollEffect=function(b,c,f){var d=a(this);m.registerEffect(f?f:null,d,b,c);return this};a.fn.clearScrollEffects=function(){var b=a(this);b.removeClass("scroll_effect");m.cssProxy.clearCacheForElement(b);for(b=0;b<m.effects.length;)m.effects[b].elem.is(this)?m.effects.splice(b,1):b++};a.fn.cloneScrollEffectsFrom=
function(a){for(var b=m.effects.length,c=0;c<b;c++){var f=m.effects[c];f.elem.is(a)&&f.clone&&f.clone(this)}}})(jQuery);
(function(a){var b=a(window),c=a(document),d=a("html"),g=a("body"),f=a("#page"),j=function(a,b){this.wrapper=a;this.onScrollFn=b;this.type="StandardScrollProvider"};j.prototype.activate=function(){b.scroll(this,this.onUpdate);b.on("mousewheel",this,this.onMouseWheel);b.resize(this,this.onUpdate);this.onUpdate()};j.prototype.deactivate=function(){b.off("scroll",this.onUpdate);b.off("mousewheel",this.onMouseWheel);b.off("resize",this.onUpdate)};j.prototype.scrollTop=function(){return b.scrollTop()};
j.prototype.scrollLeft=function(){return b.scrollLeft()};j.prototype.onUpdate=function(a){a=a&&a.data||this;a.onScrollFn(a.scrollLeft(),a.scrollTop())};j.prototype.onMouseWheel=function(){};j.prototype.scrollTo=function(a,b){window.scrollTo(a,b)};j.prototype.scrollHeight=function(){return(document.documentElement||document.body).scrollHeight};j.prototype.scrollWidth=function(){return(document.documentElement||document.body).scrollWidth};var h=function(b,c){this.wrapper=b;this.onScrollFn=c;this.moveStarted=
!1;this.animation=null;this.scrollOffset={x:0,y:0};this.speed={x:0,y:0};this.lastTouch={x:0,y:0};this.metaViewPort=a("meta[name=viewport]");this.enabled=!0;this.type="WebkitScrollProvider";this.touchListeners=[]};h.DECELERATION_RATE=1.5;h.SCALE=1;h.LOCK_X=!1;h.LOCK_Y=!1;h.HTML_WRAPPER_ID="webit_scroll_provider_wrapper";h.IFRAME_BODY_CLASS="WebkitScrollProviderIframeBodyHelperClass";h.IFRAME_DATA="WebkitScrollProviderIframeData";h.prototype.available=function(){if(this.enabled&&"ontouchstart"in window&&
jQuery.browser.SafariMobile&&jQuery.browser.SafariMobile.input&&jQuery.browser.SafariMobile.input.match){var a=jQuery.browser.SafariMobile.input.match(/version\/([\d\.]+)/i);if(a&&2==a.length&&a[1].split(".")[0]<=7)return!0}return!1};h.prototype.activate=function(){a("script").remove();f.wrap('<div id="'+h.HTML_WRAPPER_ID+'" />');this.htmlWrapper=a("#"+h.HTML_WRAPPER_ID+"");this.docProps={paddingTop:Muse.Utils.getCSSIntValue(g,"padding-top")+Muse.Utils.getCSSIntValue(g,"margin-top"),paddingBottom:Muse.Utils.getCSSIntValue(g,
"padding-bottom")+Muse.Utils.getCSSIntValue(g,"margin-bottom"),paddingLeft:Muse.Utils.getCSSIntValue(f,"margin-left"),paddingRight:Muse.Utils.getCSSIntValue(f,"margin-right")};this.htmlWrapper.css("padding-top",this.docProps.paddingTop);this.htmlWrapper.css("padding-bottom",this.docProps.paddingBottom);this.htmlWrapper.css("width","100%");this.htmlWrapper.css("min-width",f.outerWidth());this.htmlWrapper.addClass("html");d.removeClass("html");g.addClass("scroll_wrapper");b.scroll(this,this.onWindowScroll);
b.on("orientationchange",this,this.orientationChange);this.addTouchListeners(c);a("input,textarea").on("touchstart",this,this.onElementTouchStart);a("input,textarea").on("focus",this,this.onElementFocus);a("input,textarea").on("blur",this,this.onElementBlur);var j=this;a(".animationContainer").each(function(){var b=a(this);b.load(function(){var c=b.contents();j.addTouchListeners(c);a("body",c).addClass(h.IFRAME_BODY_CLASS);a("body",c).data(h.IFRAME_DATA,b)})})};h.prototype.onElementTouchStart=function(a){a.data.inFormFieldEditMode=
!0};h.prototype.onElementFocus=function(a){a=a.data;if(a.stopTimeout)clearTimeout(a.stopTimeout),a.stopTimeout=0};h.prototype.onElementBlur=function(a){var b=a.data;b.stopTimeout=setTimeout(function(){b.stopTimeout=0;b.inFormFieldEditMode=!1},200)};h.prototype.addTouchListeners=function(a){a.on("touchstart",this,this.touchStartHandler);a.on("touchmove",this,this.touchMoveHandler);a.on("touchend",this,this.touchEndHandler);this.touchListeners.push(a)};h.prototype.removeTouchListeners=function(){for(var a=
0,b,c=this.touchListeners.length;a<c;a++)b=this.touchListeners[a],b.off("touchstart",this.touchStartHandler),b.off("touchmove",this.touchMoveHandler),b.off("touchend",this.touchEndHandler);this.touchListeners.splice(0,this.touchListeners.length)};h.prototype.deactivate=function(){b.off("scroll",this.onWindowScroll);b.off("orientationchange",this.orientationChange);this.removeTouchListeners();g.removeClass("scroll_wrapper");d.addClass("html");f.unwrap();a("input,textarea").off("touchstart",this.onElementTouchStart);
a("input,textarea").off("focus",this.onElementFocus);a("input,textarea").off("blur",this.onElementBlur)};h.prototype.onWindowScroll=function(a){var a=a.data,c=b.scrollLeft(),f=b.scrollTop();if(!a.inFormFieldEditMode&&(0!=c||0!=f))window.scrollTo(0,0),a.scrollTo(c,f)};h.prototype.orientationChange=function(a){a=a.data;a.animation&&a.animation.stop(!1,!1);a.scrollTo(a.scrollOffset.x,a.scrollOffset.y)};h.prototype.canStartScroll=function(a){return!a.tagName.match(/input|textarea|select/i)};h.prototype.getIFrameScrollOffset=
function(b){b=a("body",a(b).parents());if(b.hasClass(h.IFRAME_BODY_CLASS))return b.data(h.IFRAME_DATA).offset()};h.prototype.touchStartHandler=function(a){var b=a.data,c=a.originalEvent;Muse.Assert.assert(!b.moveStarted,"Starting touch tracking while already tracking movement?");if(b.canStartScroll(a.target))b.animation&&b.animation.stop(!1,!1),b.speed.y=b.speed.x=0,a=b.getIFrameScrollOffset(a.target),b.lastTouch.y=c.targetTouches[0].pageY+(a?a.top:0),b.lastTouch.x=c.targetTouches[0].pageX+(a?a.left:
0),b.moveStarted=!0};h.prototype.touchMoveHandler=function(a){var b=a.data,c=a.originalEvent;a.preventDefault();if(b.moveStarted)a=b.getIFrameScrollOffset(a.target),b.scrollByDelta(b.lastTouch.x-c.targetTouches[0].pageX-(a?a.left:0),b.lastTouch.y-c.targetTouches[0].pageY-(a?a.top:0)),b.lastTouch.y=c.targetTouches[0].pageY+(a?a.top:0),b.lastTouch.x=c.targetTouches[0].pageX+(a?a.left:0)};h.prototype.touchEndHandler=function(b){var c=b.data;if(c.moveStarted){c.moveStarted=!1;var f=20/h.DECELERATION_RATE,
d=c.speed.x,g=c.speed.y,b=(1.71+0.0020*Math.sqrt(Math.pow(f*d,2)+Math.pow(f*g,2)))/h.DECELERATION_RATE*1E3/1.71,j=0,i=0;c.animation=a({progress:0}).animate({progress:1},{duration:b,easing:"linear",step:function(a){j=c.decelerate(a);c.scrollByDelta(Math.round((j-i)*f*d),Math.round((j-i)*f*g));i=j}})}};h.prototype.decelerate=function(a){return(1-a)*(1-a)*(1-a)*0+3*(1-a)*(1-a)*a*1+3*(1-a)*a*a*1+a*a*a*1};h.prototype.scrollByDelta=function(a,b){this.scrollTo(h.SCALE*(this.scrollOffset.x+a),h.SCALE*(this.scrollOffset.y+
b));h.LOCK_X||(this.speed.x=0.75*a*h.SCALE);h.LOCK_Y||(this.speed.y=0.75*b*h.SCALE)};h.prototype.scrollTop=function(){return this.scrollOffset.y};h.prototype.scrollLeft=function(){return this.scrollOffset.x};h.prototype.scrollHeight=function(){return this.htmlWrapper.outerHeight()};h.prototype.scrollWidth=function(){return this.htmlWrapper.outerWidth()};h.prototype.scrollTo=function(a,b){h.LOCK_X||(this.scrollOffset.x=Math.min(Math.max(0,a),Math.max(0,this.scrollWidth()-window.innerWidth)));h.LOCK_Y||
(this.scrollOffset.y=Math.min(Math.max(0,b),Math.max(0,this.scrollHeight()-window.innerHeight)));this.speed.x=this.speed.y=0;g.css({top:(h.LOCK_Y?0:-this.scrollOffset.y)+"px",left:(h.LOCK_X?0:-this.scrollOffset.x)+"px"});this.onScrollFn(0,this.scrollOffset.y)};var i=function(){var c=this;this.updateCallbacks=[];this.enabled=!0;this.STANDARD_PROVIDER=new j(this,function(a,b){c.onScroll(a,b)});this.WEBKIT_PROVIDER=new h(this,function(a,b){c.onScroll(a,b)});this.provider=this.getProvider();this.provider.activate();
a("body").on("muse_bp_activate",function(){c.onBPActivate()}).on("muse_bp_deactivate",function(){c.onBPDeactivate()}).on("muse_bp_ready",function(){b.scrollTop(0);b.trigger("scroll")})};i.prototype.onBPActivate=function(){var a=this;Muse.Utils.requestAnimationFrame(function(){a.enabled=!0})};i.prototype.onBPDeactivate=function(){this.enabled=!1};i.prototype.onScroll=function(a,b){if(this.enabled)for(var c=0,f=this.updateCallbacks.length;c<f;c++)this.updateCallbacks[c](a,b)};i.prototype.getProvider=
function(){if(this.WEBKIT_PROVIDER.available())return this.WEBKIT_PROVIDER;return this.STANDARD_PROVIDER};i.prototype.registerUpdateCallback=function(a){this.updateCallbacks.push(a)};i.prototype.isStandard=function(){return this.STANDARD_PROVIDER===this.getProvider()};i.prototype.scrollTop=function(){return this.provider.scrollTop()};i.prototype.scrollLeft=function(){return this.provider.scrollLeft()};i.prototype.scrollTo=function(a,b){this.provider.scrollTo(a,b)};i.prototype.scrollHeight=function(){return this.provider.scrollHeight()};
i.prototype.scrollWidth=function(){return this.provider.scrollWidth()};c.ready(function(){var a=b.data("scrollEffectsService"),c=new i;c.registerUpdateCallback(function(b,c){a.onUpdate(b,c)});b.data("scrollWrapper",c);c.onScroll(c.scrollLeft(),c.scrollTop())})})(jQuery);
;(function(){if(!("undefined"==typeof Muse||"undefined"==typeof Muse.assets)){var a=function(a,b){for(var c=0,d=a.length;c<d;c++)if(a[c]==b)return c;return-1}(Muse.assets.required,"jquery.scrolleffects.js");if(-1!=a){Muse.assets.required.splice(a,1);for(var a=document.getElementsByTagName("meta"),b=0,c=a.length;b<c;b++){var d=a[b];if("generator"==d.getAttribute("name")){"2015.2.0.352"!=d.getAttribute("content")&&Muse.assets.outOfDate.push("jquery.scrolleffects.js");break}}}}})();