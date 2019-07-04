/** EasyWeb pro v3.0.5 data:2019-03-24 License By http://easyweb.vip */

layui.define(["layer", "element"], function(f) {
	var i = layui.jquery;
	var m = layui.layer;
	var j = layui.element;
	var a = ".layui-layout-admin>.layui-body";
	var e = ".layui-layout-admin>.layui-side>.layui-side-scroll";
	var l = ".layui-layout-admin>.layui-header";
	var d = "admin-side-nav";
	var c = "theme-admin";
	var p = {
		defaultTheme: "theme-admin",
		tableName: "easyweb-pro",
		flexible: function(q) {
			var r = i(".layui-layout-admin").hasClass("admin-nav-mini");
			if (r == !q) {
				return
			}
			if (q) {
				i(".layui-layout-admin").removeClass("admin-nav-mini")
			} else {
				i(".layui-layout-admin").addClass("admin-nav-mini")
			}
			p.removeNavHover();
			p.putTempData("nav-expand", q);
			b()
		},
		activeNav: function(q) {
			if (!q) {
				q = window.location.pathname;
				q = q.substring(q.indexOf("/"))
			}
			if (q && q != "") {
				i(e + ">.layui-nav .layui-nav-item .layui-nav-child dd").removeClass("layui-this");
				i(e + ">.layui-nav .layui-nav-item").removeClass("layui-this");
				var u = i(e + '>.layui-nav a[href="' + q + '"]');
				if (u && u.length > 0) {
					if (i(e + ">.layui-nav").attr("lay-accordion") == "true") {
						i(e + ">.layui-nav .layui-nav-itemed").removeClass("layui-nav-itemed")
					}
					u.parent().addClass("layui-this");
					u.parent("dd").parents(".layui-nav-child").parent().addClass("layui-nav-itemed");
					i('ul[lay-filter="' + d + '"]').addClass("layui-hide");
					var s = u.parents(".layui-nav");
					s.removeClass("layui-hide");
					i(l + ">.layui-nav>.layui-nav-item").removeClass("layui-this");
					i(l + '>.layui-nav>.layui-nav-item>a[nav-bind="' + s.attr("nav-id") + '"]').parent().addClass("layui-this");
					var r = u.offset().top + u.outerHeight() + 30 - p.getPageHeight();
					var t = 50 + 65 - u.offset().top;
					if (r > 0) {
						i(e).animate({
							"scrollTop": i(e).scrollTop() + r
						}, 100)
					} else {
						if (t > 0) {
							i(e).animate({
								"scrollTop": i(e).scrollTop() - t
							}, 100)
						}
					}
				} else {}
			} else {
				console.warn("active url is null")
			}
		},
		popupRight: function(q) {
			if (q.title == undefined) {
				q.title = false;
				q.closeBtn = false
			}
			if (q.anim == undefined) {
				q.anim = 2
			}
			if (q.fixed == undefined) {
				q.fixed = true
			}
			q.isOutAnim = false;
			q.offset = "r";
			q.shadeClose = true;
			q.area = "336px";
			q.skin = "layui-layer-adminRight";
			q.move = false;
			return p.open(q)
		},
		open: function(r) {
			if (!r.area) {
				r.area = (r.type == 2) ? ["360px", "300px"] : "360px"
			}
			if (!r.skin) {
				r.skin = "layui-layer-admin"
			}
			if (!r.offset) {
				r.offset = "35px"
			}
			if (r.fixed == undefined) {
				r.fixed = false
			}
			r.resize = r.resize != undefined ? r.resize : false;
			r.shade = r.shade != undefined ? r.shade : 0.1;
			var q = r.end;
			r.end = function() {
				m.closeAll("tips");
				q && q()
			};
			return m.open(r)
		},
		req: function(q, r, s, t) {
			p.ajax({
				url: q,
				data: r,
				type: t,
				dataType: "json",
				success: s
			})
		},
		ajax: function(r) {
			var q = r.success;
			r.success = function(s, t, v) {
				var u;
				if ("json" == r.dataType.toLowerCase()) {
					u = s
				} else {
					u = p.parseJSON(s)
				}
				u && (u = s);
				if (p.ajaxSuccessBefore(u, r.url) == false) {
					return
				}
				q(s, t, v)
			};
			r.error = function(s) {
				r.success({
					code: s.status,
					msg: s.statusText
				})
			};
			r.beforeSend = function(u) {
				var t = p.getAjaxHeaders(r.url);
				for (var s = 0; s < t.length; s++) {
					u.setRequestHeader(t[s].name, t[s].value)
				}
			};
			i.ajax(r)
		},
		ajaxSuccessBefore: function(q, r) {
			return true
		},
		getAjaxHeaders: function(q) {
			var r = new Array();
			return r
		},
		parseJSON: function(s) {
			if (typeof s == "string") {
				try {
					var r = JSON.parse(s);
					if (typeof r == "object" && r) {
						return r
					}
				} catch (q) {}
			}
		},
		showLoading: function(t, s, r) {
			var q = ['<div class="ball-loader"><span></span><span></span><span></span><span></span></div>', '<div class="rubik-loader"></div>'];
			if (!t) {
				t = "body"
			}
			if (s == undefined) {
				s = 1
			}
			i(t).addClass("page-no-scroll");
			var u = i(t).children(".page-loading");
			if (u.length <= 0) {
				i(t).append('<div class="page-loading">' + q[s - 1] + "</div>");
				u = i(t).children(".page-loading")
			}
			r && u.css("background-color", "rgba(255,255,255," + r + ")");
			u.show()
		},
		removeLoading: function(r, t, q) {
			if (!r) {
				r = "body"
			}
			if (t == undefined) {
				t = true
			}
			var s = i(r).children(".page-loading");
			if (q) {
				s.remove()
			} else {
				t ? s.fadeOut() : s.hide()
			}
			i(r).removeClass("page-no-scroll")
		},
		putTempData: function(q, r) {
			if (r != undefined && r != null) {
				layui.sessionData("tempData", {
					key: q,
					value: r
				})
			} else {
				layui.sessionData("tempData", {
					key: q,
					remove: true
				})
			}
		},
		getTempData: function(q) {
			var r = layui.sessionData("tempData");
			if (r) {
				return r[q]
			} else {
				return false
			}
		},
		refresh: function() {
			location.reload()
		},
		changeTheme: function(w) {
			if (w) {
				layui.data(p.tableName, {
					key: "theme",
					value: w
				});
				if (c == w) {
					w = undefined
				}
			} else {
				layui.data(p.tableName, {
					key: "theme",
					remove: true
				})
			}
			p.removeTheme(top);
			!w || top.layui.link(p.getThemeDir() + w + ".css", w);
			var x = top.window.frames;
			for (var s = 0; s < x.length; s++) {
				var u = x[s];
				try {
					p.removeTheme(u)
				} catch (v) {}
				if (w && u.layui) {
					u.layui.link(p.getThemeDir() + w + ".css", w)
				}
				var t = u.frames;
				for (var r = 0; r < t.length; r++) {
					var q = t[r];
					try {
						p.removeTheme(q)
					} catch (v) {}
					if (w && q.layui) {
						q.layui.link(p.getThemeDir() + w + ".css", w)
					}
				}
			}
		},
		removeTheme: function(q) {
			if (!q) {
				q = window
			}
			if (q.layui) {
				var r = "layuicss-theme";
				q.layui.jquery('link[id^="' + r + '"]').remove()
			}
		},
		getThemeDir: function() {
			return layui.cache.base + "theme/"
		},
		closeThisDialog: function() {
			parent.layer.close(parent.layer.getFrameIndex(window.name))
		},
		closeDialog: function(q) {
			var r = i(q).parents(".layui-layer").attr("id").substring(11);
			m.close(r)
		},
		iframeAuto: function() {
			parent.layer.iframeAuto(parent.layer.getFrameIndex(window.name))
		},
		getPageHeight: function() {
			return document.documentElement.clientHeight || document.body.clientHeight
		},
		getPageWidth: function() {
			return document.documentElement.clientWidth || document.body.clientWidth
		},
		removeNavHover: function() {
			i(".admin-nav-hover>.layui-nav-child").css({
				"top": "auto",
				"max-height": "none",
				"overflow": "auto"
			});
			i(".admin-nav-hover").removeClass("admin-nav-hover")
		},
		setNavHoverCss: function(s) {
			var q = i(".admin-nav-hover>.layui-nav-child");
			if (s && q.length > 0) {
				var u = (s.offset().top + q.outerHeight()) > window.innerHeight;
				if (u) {
					var r = s.offset().top - q.outerHeight() + s.outerHeight();
					if (r < 50) {
						var t = p.getPageHeight();
						if (s.offset().top < t / 2) {
							q.css({
								"top": "50px",
								"max-height": t - 50 + "px",
								"overflow": "auto"
							})
						} else {
							q.css({
								"top": s.offset().top,
								"max-height": t - s.offset().top,
								"overflow": "auto"
							})
						}
					} else {
						q.css("top", r)
					}
				} else {
					q.css("top", s.offset().top)
				}
				k = true
			}
		}
	};
	p.events = {
		flexible: function(r) {
			var q = i(".layui-layout-admin").hasClass("admin-nav-mini");
			p.flexible(q)
		},
		refresh: function() {
			p.refresh()
		},
		back: function() {
			history.back()
		},
		theme: function() {
			var q = i(this).attr("data-url");
			p.popupRight({
				id: "layer-theme",
				type: 2,
				content: q ? q : "page/tpl/tpl-theme.html"
			})
		},
		note: function() {
			var q = i(this).attr("data-url");
			p.popupRight({
				id: "layer-note",
				title: "便签",
				type: 2,
				closeBtn: false,
				content: q ? q : "page/tpl/tpl-note.html"
			})
		},
		message: function() {
			var q = i(this).attr("data-url");
			p.popupRight({
				id: "layer-notice",
				type: 2,
				content: q ? q : "page/tpl/tpl-message.html"
			})
		},
		psw: function() {
			var q = i(this).attr("data-url");
			p.open({
				id: "pswForm",
				type: 2,
				title: "修改密码",
				shade: 0,
				content: q ? q : "page/tpl/tpl-password.html"
			})
		},
		logout: function() {
			var q = i(this).attr("data-url");
			m.confirm("确定要退出登录吗？", {
				title: "温馨提示",
				skin: "layui-layer-admin"
			}, function() {
				location.replace(q ? q : "/")
			})
		},
		fullScreen: function(w) {
			var y = "layui-icon-screen-full",
				s = "layui-icon-screen-restore";
			var q = i(this).find("i");
			var v = document.fullscreenElement || document.msFullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || false;
			if (v) {
				var u = document.exitFullscreen || document.webkitExitFullscreen || document.mozCancelFullScreen || document.msExitFullscreen;
				if (u) {
					u.call(document)
				} else {
					if (window.ActiveXObject) {
						var x = new ActiveXObject("WScript.Shell");
						x && x.SendKeys("{F11}")
					}
				}
				q.addClass(y).removeClass(s)
			} else {
				var r = document.documentElement;
				var t = r.requestFullscreen || r.webkitRequestFullscreen || r.mozRequestFullScreen || r.msRequestFullscreen;
				if (t) {
					t.call(r)
				} else {
					if (window.ActiveXObject) {
						var x = new ActiveXObject("WScript.Shell");
						x && x.SendKeys("{F11}")
					}
				}
				q.addClass(s).removeClass(y)
			}
		},
		closeDialog: function() {
			p.closeThisDialog()
		},
		closePageDialog: function() {
			p.closeDialog(this)
		}
	};
	i("body").on("click", "*[ew-event]", function() {
		var q = i(this).attr("ew-event");
		var r = p.events[q];
		r && r.call(this, i(this))
	});
	i("body").on("click", "*[ew-href]", function() {
		var q = i(this).attr("ew-href");
		var r = i(this).text();
		top.layui.index.openTab({
			title: r,
			url: q
		})
	});
	i("body").on("mouseenter", "*[lay-tips]", function() {
		var q = i(this).attr("lay-tips");
		var r = i(this).attr("lay-direction");
		var s = i(this).attr("lay-bg");
		m.tips(q, this, {
			tips: [r || 3, s || "#333333"],
			time: -1
		})
	}).on("mouseleave", "*[lay-tips]", function() {
		m.closeAll("tips")
	});
	var h = ".layui-layout-admin .site-mobile-shade";
	if (i(h).length <= 0) {
		i(".layui-layout-admin").append('<div class="site-mobile-shade"></div>')
	}
	i(h).click(function() {
		p.flexible(true)
	});
	i(e + ' a[href=""]').removeAttr("href");
	i(e + ' a[href="javascript:;"]').removeAttr("href");
	j.on("nav(admin-side-nav)", function(r) {
		var q = i(r);
		if ("true" == (i(e + ">.layui-nav-tree").attr("lay-accordion"))) {
			if ((q.parent().hasClass("layui-nav-itemed")) || (q.parent().hasClass("layui-this"))) {
				i(e + ">.layui-nav .layui-nav-itemed").not(q.parents(".layui-nav-child").parent()).removeClass("layui-nav-itemed");
				q.parent().addClass("layui-nav-itemed")
			}
			q.trigger("mouseenter")
		}
		p.setNavHoverCss(q.parentsUntil(".layui-nav-item").parent().children().eq(0))
	});
	var k = false;
	i("body").on("mouseenter", ".layui-layout-admin.admin-nav-mini .layui-side .layui-nav .layui-nav-item>a", function() {
		if (p.getPageWidth() > 750) {
			var s = i(this);
			i(".admin-nav-hover>.layui-nav-child").css("top", "auto");
			i(".admin-nav-hover").removeClass("admin-nav-hover");
			s.parent().addClass("admin-nav-hover");
			var q = i(".admin-nav-hover>.layui-nav-child");
			if (q.length > 0) {
				p.setNavHoverCss(s)
			} else {
				var r = s.find("cite").text();
				m.tips(r, s, {
					tips: [2, "#333333"],
					time: -1
				})
			}
		}
	}).on("mouseleave", ".layui-layout-admin.admin-nav-mini .layui-side .layui-nav .layui-nav-item>a", function() {
		m.closeAll("tips")
	});
	i("body").on("mouseleave", ".layui-layout-admin.admin-nav-mini .layui-side", function() {
		k = false;
		setTimeout(function() {
			if (!k) {
				p.removeNavHover()
			}
		}, 500)
	});
	i("body").on("mouseenter", ".layui-layout-admin.admin-nav-mini .layui-side .layui-nav .layui-nav-item.admin-nav-hover .layui-nav-child", function() {
		k = true
	});
	var n = true;
	var b = function() {
			n = false;
			setTimeout(function() {
				n = false;
				i(window).resize();
				setTimeout(function() {
					n = true
				}, 100)
			}, 500)
		};
	i(window).on("resize", function() {
		if (n) {
			setTimeout(function() {
				n = false;
				i(window).resize();
				setTimeout(function() {
					n = true
				}, 100)
			}, 500)
		}
	});
	if (p.getPageWidth() > 750) {
		var o = p.getTempData("nav-expand");
		(o == undefined) || p.flexible(o)
	}
	var g = layui.data(p.tableName);
	if (g) {
		if (g.openFooter != undefined && g.openFooter == false) {
			i("body.layui-layout-body").addClass("close-footer")
		}
		if (g.theme) {
			(g.theme == c) || layui.link(p.getThemeDir() + g.theme + ".css", g.theme)
		} else {
			if (c != p.defaultTheme) {
				layui.link(p.getThemeDir() + p.defaultTheme + ".css", p.defaultTheme)
			}
		}
	}
	f("admin", p)
});