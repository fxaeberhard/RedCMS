YUI.add("redcms-treeview",function(c){var b,a="contentBox";b=c.Base.create("redcms-treeview",c.Widget,[c.RedCMS.RedCMSWidget],{_treeview:null,_tooltip:null,_treeLeafClick:function(g){var d=g.target.get(a),f={id:d.get("parentNode").getAttribute("redid"),href:d.getAttribute("href"),label:d.getContent()};this.fire("redcms:select",f);},renderUI:function(){var d=this.get(a),e=d.one("ul");this._treeview=new c.TreeView({srcNode:e,contentBox:e,boundingBox:e,type:"TreeView"});this._treeview.on("treeleaf:click",this._treeLeafClick,this);this._treeview.render();this._tooltip=new c.RedCMS.Tooltip({triggerNodes:".yui3-treeleaf",delegate:e,shim:false,zIndex:1000,autoHideDelay:10000});this._tooltip.render();this._tooltip.on("triggerEnter",function(h){var f=h.node,g;if(f){g=f.one(".redcms-tooltip-content");if(g){this.setTriggerContent(g.getContent());}else{h.preventDefault();}}else{h.preventDefault();}});d.removeClass("redcms-hidden");},destructor:function(){this._tooltip.destroy();}},{});c.namespace("RedCMS").TreeView=b;},"@VERSION@",{requires:["gallery-yui3treeview","redcms-tooltip"]});