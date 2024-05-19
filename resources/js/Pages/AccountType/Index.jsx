import React from "react";
import Layout from "../../Shared/Layout";
import Paginate, { PaginateInfo } from "../../Shared/Paginate";
import { Link, useForm } from "@inertiajs/react";
import { dateHumanize, toYearMonthDayHourMinute } from "../../Shared/utils";
import { IconEdit, IconTrash } from "@tabler/icons-react";

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
                                    {/* <th>Position Normal</th> */}
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
                                            {/* <td>{accountType.position_normal === "D" ? 'Debit' : 'Credit'}</td> */}
                                            <td>{accountType.description}</td>
                                            <td>{toYearMonthDayHourMinute(accountType.created_at)}
                                                <br />
                                                <span className="text-secondary">{dateHumanize(accountType.created_at)}</span>
                                            </td>
                                            <td>
                                                <Link href={`/account-types/${accountType.id}/edit`}>
                                                    <span className="cursor-pointer text-warning">
                                                        <IconEdit size={18} />
                                                    </span>
                                                </Link>
                                                <button
                                                    className="text-secondary cursor-pointer bg-transparent"
                                                    onClick={() => onDelete(accountType.id)} >
                                                    <IconTrash size={18} />
                                                </button>
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



