import { Head } from "@inertiajs/react";
import { Sidebar } from "./Sidebar";
import Navbar from "./Navbar";
import PageTitle from "./PageTitle";
import Footer from "./Footer";

export default function Layout({ children }) {
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
          <div className="page-header d-print-none">
            <div className="container-xl">
              <PageTitle />
            </div>
          </div>

          <div className="page-body">
            <div className="container-xl" style={{ minHeight: '65vh' }}>{children}</div>
          </div>
          <Footer />
        </div>
      </div>
    </>
  );
}
