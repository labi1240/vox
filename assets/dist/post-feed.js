!function(e){"function"==typeof define&&define.amd?define("postFeed",e):e()}(function(){"use strict";window.render_post_feeds=()=>{let s=(s,n)=>{s.addClass("vx-loading");var e=jQuery.param(n.filters),e=Voxel_Config.ajax_url+"&action=search_posts&"+e;jQuery.get(e,e=>{s.removeClass("vx-loading");let t=[],a=jQuery('<div class="response-wrapper">'+e+"</div>");a.find('link[rel="stylesheet"]').each((e,a)=>{a.id&&!document.querySelector("#vx-assets-cache #"+CSS.escape(a.id))&&(jQuery(a).appendTo("#vx-assets-cache"),t.push(new Promise(e=>{a.onload=e})))}),a=a.children(),Promise.all(t).then(()=>{requestAnimationFrame(()=>{var e;"prev_next"===n.pagination?(s.find(".post-feed-grid:first").html(a),e=s.find("script.info"),s.find(".feed-pagination .ts-load-prev")[e.data("has-prev")?"removeClass":"addClass"]("disabled"),s.find(".feed-pagination .ts-load-next")[e.data("has-next")?"removeClass":"addClass"]("disabled"),s.find(".feed-pagination")[e.data("has-prev")||e.data("has-next")?"removeClass":"addClass"]("hidden"),e.remove()):"load_more"===n.pagination&&(s.find(".post-feed-grid:first").append(a),e=s.find("script.info"),s.find(".feed-pagination .ts-load-more")[e.data("has-next")?"removeClass":"addClass"]("hidden"),e.remove()),s.find('script[type="text/javascript"]').each((e,a)=>{a.id&&(2<=jQuery(`script[id="${CSS.escape(a.id)}"]`).length?a.remove():jQuery(a).appendTo("#vx-assets-cache"))}),jQuery(document).trigger("voxel:markup-update")})})}).fail(()=>Voxel.alert(Voxel_Config.l10n.ajaxError,"error"))};Array.from(document.querySelectorAll(".ts-post-feed--standalone:not(.vx-event-pagination)")).forEach(e=>{e.classList.add("vx-event-pagination");let a=JSON.parse(e.dataset.tsConfig),t=jQuery(e);t.find(".feed-pagination .ts-load-prev").on("click",e=>{e.preventDefault(),e.target.classList.contains("disabled")||(a.filters.pg=1<a.filters.pg?a.filters.pg-1:1,s(t,a))}),t.find(".feed-pagination .ts-load-next").on("click",e=>{e.preventDefault(),e.target.classList.contains("disabled")||(a.filters.pg+=1,s(t,a))}),t.find(".feed-pagination .ts-load-more").on("click",e=>{e.preventDefault(),a.filters.pg+=1,s(t,a)})})},window.render_post_feeds(),jQuery(document).on("voxel:markup-update",window.render_post_feeds)});