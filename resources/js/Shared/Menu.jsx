import { Link } from "@inertiajs/react";
import React from "react";
import { IconDatabase, IconNotebook, IconReport } from '@tabler/icons-react';
import { usePage } from '@inertiajs/react'
import { IconHome } from "@tabler/icons-react";
import MenuItem from "./MenuItem";
import { IconSettings } from "@tabler/icons-react";



const Menu = () => {
    const { url, component } = usePage()

    const isActive = (path) => {
        return url.startsWith(path) ? 'active' : '';
    }

    return (
        <ul className="navbar-nav pt-lg-3">
            <MenuItem
                title="Home"
                icon={<IconHome />}
                link="/home"
                isActive={isActive('/home')}
            />
            <MenuItem
                title="Master"
                icon={<IconDatabase />}
                isActive={isActive('/account')}
                type="dropdown"
            >
                <Link className="dropdown-item" href="/account-helpers">
                    Account Helper
                </Link>
                <Link className="dropdown-item" href="/account-types">
                    Type
                </Link>
                <Link className="dropdown-item" href="/accounts">
                    Account
                </Link>
            </MenuItem>
            <MenuItem
                title="Journal"
                icon={<IconNotebook />}
                isActive={isActive('/journals')}
                type="dropdown"
            >
                <Link className="dropdown-item" href="/journals">
                    Journals
                </Link>

                <Link className="dropdown-item" href="/journals/create">
                    New
                </Link>
            </MenuItem>
            <MenuItem
                title="Laporan Pendukung"
                icon={<IconReport />}
                isActive={isActive('/reports')}
                type="dropdown"
            >
                <Link className="dropdown-item" href="/reports/general-ledger">
                    General Ledger
                </Link>
                <Link className="dropdown-item" href="/reports/account-helper">
                    Buku Pembantu
                </Link>
                <Link className="dropdown-item" href="/reports/worksheet">
                    Neraca Lajur
                </Link>
                <Link className="dropdown-item" href="/journals/new">
                    Ringkasan Bisnis
                </Link>
            </MenuItem>
            <MenuItem
                title="Laporan Keuangan"
                icon={<IconReport />}
                isActive={isActive('/financial-statements')}
                type="dropdown"
            >
                <Link className="dropdown-item" href="/reports/profit-loss">
                    Laba Rugi
                </Link>
                <Link className="dropdown-item" href="/journals/new">
                    Ekuitas
                </Link>
                <Link className="dropdown-item" href="/reports/balance-sheet">
                    Neraca
                </Link>
                <Link className="dropdown-item" href="/journals/new">
                    Arus Kas
                </Link>
            </MenuItem>
            <MenuItem
                title="Settings"
                icon={<IconSettings />}
                isActive={isActive('/settings')}
                type="dropdown"
            >
                <Link className="dropdown-item" href="/setting-reports/profit-loss">
                    Laba Rugi
                </Link>
                <Link className="dropdown-item" href="/setting-reports/balance-sheet">
                    Neraca
                </Link>
                <Link className="dropdown-item" href="/setting-users">
                    Users
                </Link>
            </MenuItem>
        </ul>
    );
};

export default Menu;
