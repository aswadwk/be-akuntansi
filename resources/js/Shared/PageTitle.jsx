import React from "react";

const defaultLeft = (
    <div className="col">
        <div className="page-pretitle">Overview</div>
        <h2 className="page-title">Combo layout</h2>
    </div>
);

const defaultRight = (
    <div className="col-auto ms-auto d-print-none">
        <div className="btn-list">
            <span className="d-none d-sm-inline">
                <a href="#" className="btn">
                    New view
                </a>
            </span>
            <a
                href="#"
                className="btn btn-primary d-none d-sm-inline-block"
                data-bs-toggle="modal"
                data-bs-target="#modal-report"
            >
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
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Create new report
            </a>
            <a
                href="#"
                className="btn btn-primary d-sm-none btn-icon"
                data-bs-toggle="modal"
                data-bs-target="#modal-report"
                aria-label="Create new report"
            >
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
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
            </a>
        </div>
    </div>
);

const PageTitle = ({ left, right }) => {
    return (
        <div className="page-header d-print-none">
            <div className="container-xl">
                <div className="row g-2 align-items-center">
                    <div className="col">
                        <div className="page-pretitle">Overview</div>
                        <h2 className="page-title">{left}</h2>
                    </div>
                    <div className="col-auto ms-auto d-print-none">
                        <div className="btn-list">
                            {right || defaultRight}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default PageTitle;
