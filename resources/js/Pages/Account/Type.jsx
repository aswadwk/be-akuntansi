import React from "react";
import Layout from "../../Shared/Layout";
import { Link } from "@inertiajs/react";
import Paginate, { PaginateInfo } from "../../Shared/Paginate";

const AccountType = ({ accountTypes }) => {
    return (
        <Layout>
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
                                            <td>{accountType.position_normal==="D" ? 'Debit' : 'Credit' }</td>
                                            <td>{accountType.description}</td>
                                            <td>{accountType.created_at}</td>
                                            <td></td>
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

export default AccountType;
