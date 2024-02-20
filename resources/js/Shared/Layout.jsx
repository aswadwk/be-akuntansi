import { Head } from "@inertiajs/react";
import { Sidebar } from "./Sidebar";
import Navbar from "./Navbar";
import PageTitle from "./PageTitle";
import Footer from "./Footer";
import 'rsuite/dist/rsuite.min.css';

export default function Layout({ children, left, right, pageTitle }) {
    return (
        <>
            <Head>
                <title>Akuntansi One</title>
                <meta name="description" content="Your page description" />
            </Head>
            <div className="page">
                <Sidebar />
                <Navbar />
                <div className="page-wrapper">
                    {pageTitle}
                    <PageTitle left={left} right={right} />

                    <div className="page-body">
                        <div
                            className="container-xl"
                            style={{ minHeight: "67vh" }}
                        >
                            {children}
                        </div>
                    </div>
                    <Footer />
                </div>
            </div>
        </>
    );
}
