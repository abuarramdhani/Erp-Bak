/**
 * ---zzz---
 * Depend on jquery
 * Too complex if using jquery :"
 */

/**
 * TODO
 * - maybe will buggy
 *   because ajax of fetch new notification is call at same time with fetch all notification
 * - Make more beauty popup notification
 * - button to set read all
 *
 * INFORMATION
 * - just 50 latest notification will be appear
 */

"use strict";

// Global listener
$(".dropdown-menu").on("click", function (e) {
	e.stopPropagation();
});
$(".notification-wrapper.slimscroll").slimscroll({
	height: "500px",
	size: "5px",
});

// scope environment
!(function () {
	const constant = {
		DELAY: 10000, // 10 second
	};

	/**
	 * State is like temporary memory that will usefull
	 * You can store any variable in state
	 * so this just basic variable with state
	 * read vue, react state
	 */
	const state = {
		notifications: {
			all: Array,
			new: Array,
			// last_get: String, not yet needed
		},
	};

	/**
	 * Endpoint of api
	 */
	const services = {
		notification: {
			base: baseurl + "api/services/notification",
			get all() {
				return this.base + "/";
			},
			get new() {
				return this.base + "/new";
			},
			get read() {
				return this.base + "/read";
			},
			get readAll() {
				return this.base + "/read/all";
			},
			get delete() {
				return this.base + "/delete";
			},
			get deleteAll() {
				return this.base + "/delete/all";
			},
		},
	};

	/**
	 * FAILED WAYS
	 */
	// make scoped Toast
	const toaster = $.toaster;

	// custom style of toast
	toaster({
		settings: {
			toaster: {
				id: "toaster",
				container: "body",
				template: "<div></div>",
				class: "toaster",
				css: {
					position: "fixed",
					top: "10px",
					right: "10px",
					width: "300px",
					zIndex: 50000,
				},
			},

			toast: {
				template: `
					<div class="alert alert-%priority% alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<span class="title"></span>: <span class="message"></span>
					</div>
				`,
				css: {},
				cssm: {},
				csst: { fontWeight: "bold" },

				fade: "slow",

				display: function ($toast) {
					return $toast.fadeIn(this.fade);
				},

				remove: function ($toast, callback) {
					return $toast.animate(
						{
							opacity: "0",
							padding: "0px",
							margin: "0px",
							height: "0px",
						},
						{
							duration: this.fade,
							complete: callback,
						}
					);
				},
			},

			debug: false,
			timeout: 1500,
			stylesheet: null,
			donotdismiss: [],
		},
	});

	const core = {
		notification: {
			element: "#notification-container",
			counter: "#notification-counter",
			button: "#notification-toggler",
			template({ user_notification_id, title, message, created_at, readed_at, url }) {
				const day = () => {
					// if created at is today
					if (moment(created_at).isSame(moment(), "day")) return "Hari ini";
					// if created at == (today - 1) a.k.a yesterday
					if (moment(created_at).format("DD-MM-YYYY") == moment().subtract(1, "days").format("DD-MM-YYYY")) return "Kemarin";

					// if not today or yesterday, show created day with format
					return moment(created_at).format("DD/MM/YYYY");
				};

				return `
				<li  data-url="${baseurl + "/notifications/" + user_notification_id}" class="nav-item notification-item ${!readed_at ? "unread" : ""}">
					<div class="row">
						<div class="col-md-12">
							<div class="col-lg-2" style="padding-top: 1em;">
								<div style="width: 10px; height: 10px; margin: auto; background-color: #3c8dbc; border-radius: 50%;"></div>
							</div>
							<div class="col-lg-7">
								<span style="font-weight: bold; font-size: 1.8rem;">${title}</span>
								<p>${message}</p>
							</div>
							<div class="col-lg-2">
								<span style="font-size: 1.2rem;">${day()}</span>
								<span style="font-size: 1.2rem;">${created_at ? moment(created_at).format("H:mm:s") : ""}</span>
							</div>
							<a data-id="${user_notification_id}" class="stretched-link" href="${url ? baseurl + "/notifications/" + user_notification_id : "#"}"></a>
						</div>
					</div>
				</li>
				`;
			},
			/**
			 * Render notification item based state
			 */
			render() {
				// clear notificatio item
				$(this.element).html("");

				let html = "";
				// generate template
				state.notifications.all.forEach((item) => {
					html += this.template(item);
				});

				if (state.notifications.all.length === 0) {
					html = `
						<li class="text-center" style="padding: 1em;">
							<span>Tidak ada notifikasi</span>
						</li>
					`;
				}

				// filter notification with unread
				const newNotification = state.notifications.all.filter((item) => {
					return !item.readed_at; // is null
				});

				if (newNotification.length) {
					$(this.counter).text(`${newNotification.length} Notifikasi Baru`);
					$(this.button).addClass("blink");
				} else {
					$(this.counter).text("");
					$(this.button).removeClass("blink");
				}

				// render to view
				$(this.element).html(html);
				// add onclick event
				this.event.itemOnclick();
			},
			event: {
				itemOnclick() {
					// will set readed
					let element = core.notification.element;
					$(element)
						.find("a")
						.click(function () {
							const self = this;
							const id = $(this).data("id");
							const url = $(this).data("url");
							// do something
							$.ajax({
								method: "POST",
								url: services.notification.read,
								data: {
									id: id,
								},
								success() {
									console.log("Ok");
									$(self).closest("li").removeClass("unread");
									// set state where id
									const index = state.notifications.all.findIndex((item) => item.user_notification_id == id);
									if (index === null) return;
									// set readed to timestamp
									state.notifications.all[index].readed_at = moment().format("YYYY-MM-DD H:m:s");
									core.notification.render();
								},
								error() {
									console.error("Error to set read of notification");
								},
							});
						});
				},
			},
		},
	};

	/**
	 * Fetch all notification
	 * this just fetch once
	 */
	(function getAllNotification() {
		$.ajax({
			method: "POST",
			url: services.notification.all,
			data: {
				client: 1, // change it to production env
			},
			success(data) {
				// set state
				state.notifications.all = data;
			},
			complete() {
				// render
				core.notification.render();
			},
		});
	})();

	/**
	 * Get new notification every constant delay time
	 * this will show toast notification
	 */
	(function getNewNotification() {
		$.ajax({
			method: "POST",
			url: services.notification.new,
			data: {
				client: 1, // change it to production env
			},
			success(data) {
				// set state
				state.notifications.new = data;

				// if has new
				data.forEach((item) => {
					// append to all and render it
					state.notifications.all.unshift(item);

					$.toaster({
						title: item.title,
						message: item.message,
						priority: "info",
						settings: {
							timeout: 20000, // 20 second
						},
					});
				});

				// after all
				if (data.length) {
					// render again
					core.notification.render();
				}
			},
			error() {
				// dont show error
			},
			complete() {
				// call again after timeout
				setTimeout(getNewNotification, constant.DELAY);
			},
		});
	})();
})();
