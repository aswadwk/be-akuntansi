import React from "react";
import Layout from "../../Shared/Layout";
import { Card } from "./Card";
import { Link } from "@inertiajs/react";
import { IconPlus } from "@tabler/icons-react";

const index = ({ currentUser }) => {
    return (
        <Layout left={'Dashboard'} right={<PageTitleRight />}>
            <div className="col-12">
                <div className="row row-cards">
                    <Card title="Total Pendapatan" count="Rp. 0" />
                    <Card title="Total Pengeluaran" count="Rp. 0" />
                    <Card title="Total Laba" count="Rp. 0" />
                    <Card title="Total Piutang" count="Rp. 0" />
                </div>
            </div>
        </Layout>
    );
};

const PageTitleRight = () => {
    return (
        <div className="col-auto ms-auto d-print-none">
            <div className="btn-list">
                <Link
                    href="/journals/create"
                    className="btn btn-primary d-none d-sm-inline-block"
                >
                    <IconPlus size={18} />
                    New Journal
                </Link>
                <Link
                    href="/account-types/create"
                    className="btn btn-primary d-sm-none btn-icon"
                >
                    <IconPlus size={18} />
                </Link>
            </div>
        </div>
    )
}

export default index;
