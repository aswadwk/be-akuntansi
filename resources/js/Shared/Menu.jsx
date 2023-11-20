import { Link } from "@inertiajs/react";
import React from "react";
import { IconDatabase, IconNotebook, IconReport } from '@tabler/icons-react';
import { usePage } from '@inertiajs/react'



const Menu = () => {
    const { url, component } = usePage()

    const isActive = (path) => {
        return url.startsWith(path) ? 'active' : '';
    }

    return (
        <ul className="navbar-nav pt-lg-3">
            <li className={`nav-item ${isActive('/home')}`}>
                <Link className="nav-link" href="/home">
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
            <li className={`nav-item dropdown ${isActive('/accounts')}`}>
                <a
                    className="nav-link dropdown-toggle"
                    href="#navbar-help"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="false"
                    role="button"
                    aria-expanded="false"
                >
                    <span className="nav-link-icon d-md-none d-lg-inline-block">
                        <IconDatabase />
                    </span>
                    <span className="nav-link-title">Master</span>
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
            <li className={`nav-item dropdown ${isActive('/journals')}`}>
                <a
                    className="nav-link dropdown-toggle"
                    href="#navbar-help"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="false"
                    role="button"
                    aria-expanded="false"
                >
                    <span className="nav-link-icon d-md-none d-lg-inline-block">
                        <IconNotebook />
                    </span>
                    <span className="nav-link-title">Journal</span>
                </a>
                <div className="dropdown-menu">
                    <Link className="dropdown-item" href="/journals">
                        Journals
                    </Link>
                    <Link className="dropdown-item" href="/journals/create">
                        New
                    </Link>
                </div>
            </li>
            <li className={`nav-item dropdown ${isActive('/reports')}`}>
                <a
                    className="nav-link dropdown-toggle"
                    href="#navbar-extra"
                    data-bs-toggle="dropdown"
                    role="button"
                    aria-expanded="false"
                >
                    <span className="nav-link-icon d-md-none d-lg-inline-block">
                        <IconReport />
                    </span>
                    <span className="nav-link-title">Laporan Pendukung</span>
                </a>
                <div className="dropdown-menu">
                    <Link className="dropdown-item" href="/reports/general-ledger">
                        Buku Besar
                    </Link>
                    <Link className="dropdown-item" href="/reports/neraca-lajur">
                        Neraca Lajur
                    </Link>
                    <Link className="dropdown-item" href="/journals/new">
                        Buku Pembantu
                    </Link>
                    <Link className="dropdown-item" href="/journals/new">
                        Ringkasan Bisnis
                    </Link>
                </div>
            </li>
            <li className={`nav-item dropdown ${isActive('financial-statements')}`}>
                <a
                    className="nav-link dropdown-toggle"
                    href="#navbar-extra"
                    data-bs-toggle="dropdown"
                    role="button"
                    aria-expanded="false"
                >
                    <span className="nav-link-icon d-md-none d-lg-inline-block">
                        <IconReport />
                    </span>
                    <span className="nav-link-title">Laporan Keuangan</span>
                </a>
                <div className="dropdown-menu">
                    <Link className="dropdown-item" href="/financial-statements/balance-sheet">
                        Neraca
                    </Link>
                    <Link className="dropdown-item" href="/financial-statements/profit-loss">
                        Laba Rugi
                    </Link>
                    <Link className="dropdown-item" href="/journals/new">
                        Arus Kas
                    </Link>
                    <Link className="dropdown-item" href="/journals/new">
                        Ekuitas
                    </Link>
                </div>
            </li>
        </ul>
    );
};

export default Menu;
