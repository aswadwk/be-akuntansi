import { Link, useForm } from '@inertiajs/react';
import React from 'react'

const MenuProfile = () => {
    const { post } = useForm({});

    const onLogout = (e) => {
        e.preventDefault();
        post("/auth/logout");
    };

    return (
        <div className="nav-item dropdown">
            <a
                href="#"
                className="nav-link d-flex lh-1 text-reset p-0"
                data-bs-toggle="dropdown"
                aria-label="Open user menu"
            >
                <span
                    className="avatar avatar-sm"
                    style={{
                        backgroundImage: `url(/avatars/000m.jpg)`,
                    }}
                />
                <div className="d-none d-xl-block ps-2">
                    <div>Paweł Kuna</div>
                    <div className="mt-1 small text-muted">
                        UI Designer
                    </div>
                </div>
            </a>
            <div className="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <Link href="/auth/profile" className="dropdown-item">
                    Profile
                </Link>
                <div className="dropdown-divider"></div>
                <a
                    href="./sign-in.html"
                    className="dropdown-item"
                    onClick={(e) => onLogout(e)}
                >
                    Logout
                </a>
            </div>
        </div>
    )
}

export default MenuProfile
