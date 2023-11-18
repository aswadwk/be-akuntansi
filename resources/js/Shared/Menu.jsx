import { Link } from "@inertiajs/react";
import React from "react";

const Menu = () => {
	return (
		<ul className="navbar-nav pt-lg-3">
			<li className="nav-item active">
				<Link className="nav-link" href="/">
					<span className="nav-link-icon d-md-none d-lg-inline-block">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							className="icon"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							strokeWidth="2"
							stroke="currentColor"
							fill="none"
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<path stroke="none" d="M0 0h24v24H0z" fill="none" />
							<path d="M5 12l-2 0l9 -9l9 9l-2 0" />
							<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
							<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
						</svg>
					</span>
					<span className="nav-link-title">Home</span>
				</Link>
			</li>
			<li className="nav-item dropdown">
				<a
					className="nav-link dropdown-toggle"
					href="#navbar-help"
					data-bs-toggle="dropdown"
					data-bs-auto-close="false"
					role="button"
					aria-expanded="false"
				>
					<span className="nav-link-icon d-md-none d-lg-inline-block">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							className="icon"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							strokeWidth="2"
							stroke="currentColor"
							fill="none"
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<path stroke="none" d="M0 0h24v24H0z" fill="none" />
							<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
							<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
							<path d="M15 15l3.35 3.35" />
							<path d="M9 15l-3.35 3.35" />
							<path d="M5.65 5.65l3.35 3.35" />
							<path d="M18.35 5.65l-3.35 3.35" />
						</svg>
					</span>
					<span className="nav-link-title">Account</span>
				</a>
				<div className="dropdown-menu">
					<Link className="dropdown-item" href="/account-types">
						Type
					</Link>
					<Link className="dropdown-item" href="/accounts">
						Account
					</Link>
				</div>
			</li>
		</ul>
	);
};

export default Menu;
