YUI.add("redcms-accordion",function(a){var f,i="contentBox",e="redcms",h="redcms-accordion",c="title",j="item",k="content",d="toggled",b=a.ClassNameManager.getClassName,g={title:b(h,c),item:b(h,j),content:b(h,k),toggled:b(h,d)};f=a.Base.create("redcms-accordion",a.Widget,[a.RedCMS.RedCMSWidget],{_accordion:null,_handler:null,_currentOpenedNode:null,_closeNode:function(m){var l=m.next("."+g.item);l.transition({duration:0.3,easing:"ease-in",height:0});m.removeClass(g.toggled);},_showNode:function(m){var l=m.next("."+g.item);l.transition({duration:0.3,easing:"ease-in",height:l.one("div").getComputedStyle("height")});m.addClass(g.toggled);},_onTitleClicked:function(l){if(l.currentTarget.hasClass(g.toggled)){this._closeNode(l.currentTarget);}else{if(this._currentOpenedNode&&this._currentOpenedNode!=l.currentTarget){this._closeNode(this._currentOpenedNode);}this._showNode(l.currentTarget);this._currentOpenedNode=l.currentTarget;}},renderUI:function(){var l=this.get(i);this._handler=l.delegate("click",this._onTitleClicked,"."+g.title,this);},destructor:function(){}},{NAME:h,NS:e,CLASSES:g});a.namespace("RedCMS").Accordion=f;},"@VERSION@",{requires:["redcms-base","transition"]});