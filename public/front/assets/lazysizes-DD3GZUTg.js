import{$ as Me}from"./jquery-m0X-EPcw.js";window.jQuery=Me;var Ne={exports:{}};(function(te){(function(j,h){var d=h(j,j.document,Date);j.lazySizes=d,te.exports&&(te.exports=d)})(typeof window<"u"?window:{},function(h,d,B){var S,r;if(function(){var a,t={lazyClass:"lazyload",loadedClass:"lazyloaded",loadingClass:"lazyloading",preloadClass:"lazypreload",errorClass:"lazyerror",autosizesClass:"lazyautosizes",fastLoadedClass:"ls-is-cached",iframeLoadMode:0,srcAttr:"data-src",srcsetAttr:"data-srcset",sizesAttr:"data-sizes",minSize:40,customMedia:{},init:!0,expFactor:1.5,hFac:.8,loadMode:2,loadHidden:!0,ricTimeout:0,throttleDelay:125};r=h.lazySizesConfig||h.lazysizesConfig||{};for(a in t)a in r||(r[a]=t[a])}(),!d||!d.getElementsByClassName)return{init:function(){},cfg:r,noSupport:!0};var R=d.documentElement,ve=h.HTMLPictureElement,k="addEventListener",y="getAttribute",F=h[k].bind(h),A=h.setTimeout,ae=h.requestAnimationFrame||A,X=h.requestIdleCallback,re=/^picture$/i,ge=["load","error","lazyincluded","_lazyloaded"],Q={},ze=Array.prototype.forEach,H=function(a,t){return Q[t]||(Q[t]=new RegExp("(\\s|^)"+t+"(\\s|$)")),Q[t].test(a[y]("class")||"")&&Q[t]},$=function(a,t){H(a,t)||a.setAttribute("class",(a[y]("class")||"").trim()+" "+t)},Y=function(a,t){var n;(n=H(a,t))&&a.setAttribute("class",(a[y]("class")||"").replace(n," "))},Z=function(a,t,n){var c=n?k:"removeEventListener";n&&Z(a,t),ge.forEach(function(u){a[c](u,t)})},q=function(a,t,n,c,u){var s=d.createEvent("Event");return n||(n={}),n.instance=S,s.initEvent(t,!c,!u),s.detail=n,a.dispatchEvent(s),s},w=function(a,t){var n;!ve&&(n=h.picturefill||r.pf)?(t&&t.src&&!a[y]("srcset")&&a.setAttribute("srcset",t.src),n({reevaluate:!0,elements:[a]})):t&&t.src&&(a.src=t.src)},O=function(a,t){return(getComputedStyle(a,null)||{})[t]},ie=function(a,t,n){for(n=n||a.offsetWidth;n<r.minSize&&t&&!a._lazysizesWidth;)n=t.offsetWidth,t=t.parentNode;return n},U=function(){var a,t,n=[],c=[],u=n,s=function(){var o=u;for(u=n.length?c:n,a=!0,t=!1;o.length;)o.shift()();a=!1},v=function(o,f){a&&!f?o.apply(this,arguments):(u.push(o),t||(t=!0,(d.hidden?A:ae)(s)))};return v._lsFlush=s,v}(),G=function(a,t){return t?function(){U(a)}:function(){var n=this,c=arguments;U(function(){a.apply(n,c)})}},pe=function(a){var t,n=0,c=r.throttleDelay,u=r.ricTimeout,s=function(){t=!1,n=B.now(),a()},v=X&&u>49?function(){X(s,{timeout:u}),u!==r.ricTimeout&&(u=r.ricTimeout)}:G(function(){A(s)},!0);return function(o){var f;(o=o===!0)&&(u=33),!t&&(t=!0,f=c-(B.now()-n),f<0&&(f=0),o||f<9?v():A(v,f))}},ne=function(a){var t,n,c=99,u=function(){t=null,a()},s=function(){var v=B.now()-n;v<c?A(s,c-v):(X||u)(u)};return function(){n=B.now(),t||(t=A(s,c))}},se=function(){var a,t,n,c,u,s,v,o,f,C,L,T,ye=/^img$/i,he=/^iframe$/i,Ce="onscroll"in h&&!/(gle|ing)bot/.test(navigator.userAgent),Ee=0,V=0,m=0,I=-1,oe=function(e){m--,(!e||m<0||!e.target)&&(m=0)},le=function(e){return T==null&&(T=O(d.body,"visibility")=="hidden"),T||!(O(e.parentNode,"visibility")=="hidden"&&O(e,"visibility")=="hidden")},be=function(e,i){var l,g=e,z=le(e);for(o-=i,L+=i,f-=i,C+=i;z&&(g=g.offsetParent)&&g!=d.body&&g!=R;)z=(O(g,"opacity")||1)>0,z&&O(g,"overflow")!="visible"&&(l=g.getBoundingClientRect(),z=C>l.left&&f<l.right&&L>l.top-1&&o<l.bottom+1);return z},fe=function(){var e,i,l,g,z,p,_,M,x,N,W,P,b=S.elements;if((c=r.loadMode)&&m<8&&(e=b.length)){for(i=0,I++;i<e;i++)if(!(!b[i]||b[i]._lazyRace)){if(!Ce||S.prematureUnveil&&S.prematureUnveil(b[i])){D(b[i]);continue}if((!(M=b[i][y]("data-expand"))||!(p=M*1))&&(p=V),N||(N=!r.expand||r.expand<1?R.clientHeight>500&&R.clientWidth>500?500:370:r.expand,S._defEx=N,W=N*r.expFactor,P=r.hFac,T=null,V<W&&m<1&&I>2&&c>2&&!d.hidden?(V=W,I=0):c>1&&I>1&&m<6?V=N:V=Ee),x!==p&&(s=innerWidth+p*P,v=innerHeight+p,_=p*-1,x=p),l=b[i].getBoundingClientRect(),(L=l.bottom)>=_&&(o=l.top)<=v&&(C=l.right)>=_*P&&(f=l.left)<=s&&(L||C||f||o)&&(r.loadHidden||le(b[i]))&&(t&&m<3&&!M&&(c<3||I<4)||be(b[i],p))){if(D(b[i]),z=!0,m>9)break}else!z&&t&&!g&&m<4&&I<4&&c>2&&(a[0]||r.preloadAfterLoad)&&(a[0]||!M&&(L||C||f||o||b[i][y](r.sizesAttr)!="auto"))&&(g=a[0]||b[i])}g&&!z&&D(g)}},E=pe(fe),ue=function(e){var i=e.target;if(i._lazyCache){delete i._lazyCache;return}oe(e),$(i,r.loadedClass),Y(i,r.loadingClass),Z(i,ce),q(i,"lazyloaded")},Ae=G(ue),ce=function(e){Ae({target:e.target})},me=function(e,i){var l=e.getAttribute("data-load-mode")||r.iframeLoadMode;l==0?e.contentWindow.location.replace(i):l==1&&(e.src=i)},Le=function(e){var i,l=e[y](r.srcsetAttr);(i=r.customMedia[e[y]("data-media")||e[y]("media")])&&e.setAttribute("media",i),l&&e.setAttribute("srcset",l)},Se=G(function(e,i,l,g,z){var p,_,M,x,N,W;(N=q(e,"lazybeforeunveil",i)).defaultPrevented||(g&&(l?$(e,r.autosizesClass):e.setAttribute("sizes",g)),_=e[y](r.srcsetAttr),p=e[y](r.srcAttr),z&&(M=e.parentNode,x=M&&re.test(M.nodeName||"")),W=i.firesLoad||"src"in e&&(_||p||x),N={target:e},$(e,r.loadingClass),W&&(clearTimeout(n),n=A(oe,2500),Z(e,ce,!0)),x&&ze.call(M.getElementsByTagName("source"),Le),_?e.setAttribute("srcset",_):p&&!x&&(he.test(e.nodeName)?me(e,p):e.src=p),z&&(_||x)&&w(e,{src:p})),e._lazyRace&&delete e._lazyRace,Y(e,r.lazyClass),U(function(){var P=e.complete&&e.naturalWidth>1;(!W||P)&&(P&&$(e,r.fastLoadedClass),ue(N),e._lazyCache=!0,A(function(){"_lazyCache"in e&&delete e._lazyCache},9)),e.loading=="lazy"&&m--},!0)}),D=function(e){if(!e._lazyRace){var i,l=ye.test(e.nodeName),g=l&&(e[y](r.sizesAttr)||e[y]("sizes")),z=g=="auto";(z||!t)&&l&&(e[y]("src")||e.srcset)&&!e.complete&&!H(e,r.errorClass)&&H(e,r.lazyClass)||(i=q(e,"lazyunveilread").detail,z&&ee.updateElem(e,!0,e.offsetWidth),e._lazyRace=!0,m++,Se(e,i,z,g,l))}},_e=ne(function(){r.loadMode=3,E()}),de=function(){r.loadMode==3&&(r.loadMode=2),_e()},K=function(){if(!t){if(B.now()-u<999){A(K,999);return}t=!0,r.loadMode=3,E(),F("scroll",de,!0)}};return{_:function(){u=B.now(),S.elements=d.getElementsByClassName(r.lazyClass),a=d.getElementsByClassName(r.lazyClass+" "+r.preloadClass),F("scroll",E,!0),F("resize",E,!0),F("pageshow",function(e){if(e.persisted){var i=d.querySelectorAll("."+r.loadingClass);i.length&&i.forEach&&ae(function(){i.forEach(function(l){l.complete&&D(l)})})}}),h.MutationObserver?new MutationObserver(E).observe(R,{childList:!0,subtree:!0,attributes:!0}):(R[k]("DOMNodeInserted",E,!0),R[k]("DOMAttrModified",E,!0),setInterval(E,999)),F("hashchange",E,!0),["focus","mouseover","click","load","transitionend","animationend"].forEach(function(e){d[k](e,E,!0)}),/d$|^c/.test(d.readyState)?K():(F("load",K),d[k]("DOMContentLoaded",E),A(K,2e4)),S.elements.length?(fe(),U._lsFlush()):E()},checkElems:E,unveil:D,_aLSL:de}}(),ee=function(){var a,t=G(function(s,v,o,f){var C,L,T;if(s._lazysizesWidth=f,f+="px",s.setAttribute("sizes",f),re.test(v.nodeName||""))for(C=v.getElementsByTagName("source"),L=0,T=C.length;L<T;L++)C[L].setAttribute("sizes",f);o.detail.dataAttr||w(s,o.detail)}),n=function(s,v,o){var f,C=s.parentNode;C&&(o=ie(s,C,o),f=q(s,"lazybeforesizes",{width:o,dataAttr:!!v}),f.defaultPrevented||(o=f.detail.width,o&&o!==s._lazysizesWidth&&t(s,C,f,o)))},c=function(){var s,v=a.length;if(v)for(s=0;s<v;s++)n(a[s])},u=ne(c);return{_:function(){a=d.getElementsByClassName(r.autosizesClass),F("resize",u)},checkElems:u,updateElem:n}}(),J=function(){!J.i&&d.getElementsByClassName&&(J.i=!0,ee._(),se._())};return A(function(){r.init&&J()}),S={cfg:r,autoSizer:ee,loader:se,init:J,uP:w,aC:$,rC:Y,hC:H,fire:q,gW:ie,rAF:U},S})})(Ne);
