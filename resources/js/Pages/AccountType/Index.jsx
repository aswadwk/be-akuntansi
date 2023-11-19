import React from "react";
import Layout from "../../Shared/Layout";
import Paginate, { PaginateInfo } from "../../Shared/Paginate";
import { Link, useForm } from "@inertiajs/react";

const Index = ({ accountTypes }) => {
    const { delete: destroy } = useForm({});

    const onDelete = (accountTypeId) => {
        if (confirm('Are you sure you want to delete this account type?')) {
            // Delete it!
            destroy(`/account-types/${accountTypeId}`)
        }
    }

    return (
        <Layout left={'Account Type'} right={<PageTitleRight />}>
            <div className="col-12">
                <div className="card">
                    <div className="card-body border-bottom py-3">
                        <div className="d-flex">
                            <div className="text-secondary">
                                Show
                                <div className="mx-2 d-inline-block">
                                    <input type="text" className="form-control form-control-sm" value="8" size="3" aria-label="Invoices count" />
                                </div>
                                entries
                            </div>
                            <div className="ms-auto text-secondary">
                                Search:
                                <div className="ms-2 d-inline-block">
                                    <input type="text" className="form-control form-control-sm" aria-label="Search invoice" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="table-responsive">
                        <table className="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Position Normal</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    accountTypes.data.map((accountType, index) => (
                                        <tr key={index}>
                                            <td>{accountType.name}</td>
                                            <td>{accountType.code}</td>
                                            <td>{accountType.position_normal === "D" ? 'Debit' : 'Credit'}</td>
                                            <td>{accountType.description}</td>
                                            <td>{accountType.created_at}</td>
                                            <td>
                                                <Link href={`/account-types/${accountType.id}/edit`}>
                                                    <span className="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" className="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
                                                    </span>
                                                </Link>
                                                <span className="text-secondary cursor-pointer" onClick={() => onDelete(accountType.id)} >
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </span>
                                            </td>
                                        </tr>
                                    ))
                                }
                            </tbody>
                        </table>
                    </div>
                    <div className="card-footer d-flex align-items-center">
                        <PaginateInfo from={accountTypes.from} to={accountTypes.to} total={accountTypes.total} />
                        <Paginate links={accountTypes.links} />
                    </div>
                </div>
            </div>
        </Layout>
    )
};

export default Index;


const PageTitleRight = () => {
    return (
        <div className="col-auto ms-auto d-print-none">
            <div className="btn-list">
                <Link
                    href="/account-types/create"
                    className="btn btn-primary d-none d-sm-inline-block"
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
                    Add Account Type
                </Link>
                <Link
                    href="/account-types/create"
                    className="btn btn-primary d-sm-none btn-icon"
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
                </Link>
            </div>
        </div>
    )
}



