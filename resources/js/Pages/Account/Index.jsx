import React from "react";
import Layout from "../../Shared/Layout";
import Paginate, { PaginateInfo } from "../../Shared/Paginate";

const Index = ({accounts}) => {
    return (
        <Layout left={<PageTitleLeft />} right={<></>}>
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
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    accounts.data.map((account, index) => (
                                        <tr key={index}>
                                            <td>{account.name}</td>
                                            <td>{account.code}</td>
                                            <td>{account.position_normal==='D' ? 'Debit' : 'Credit' }</td>
                                            <td>{account?.account_type?.name ?? '-'}</td>
                                            <td>{account.description}</td>
                                            <td>{account.created_at}</td>
                                            <td></td>
                                        </tr>
                                    ))
                                }
                            </tbody>
                        </table>
                    </div>
                    <div className="card-footer d-flex align-items-center">
                        <PaginateInfo from={accounts.from} to={accounts.to} total={accounts.total} />
                        <Paginate links={accounts.links} />
                    </div>
                </div>
            </div>
        </Layout>
    )
};

export default Index;

const PageTitleLeft = () => {
    return (
        <div className="col">
        <div className="page-pretitle">Overview</div>
        <h2 className="page-title">Account</h2>
    </div>
    );
}
