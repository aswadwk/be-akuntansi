import React, { useState } from 'react'
import Paginate, { PaginateInfo } from '../../Shared/Paginate'
import Layout from '../../Shared/Layout'
import { Link } from '@inertiajs/react'
import { NumericFormat } from 'react-number-format';

const Index = ({ journals }) => {
    const [filters, setFilters] = useState({
        show: 8,
        search: ''
    })

    return (
        <Layout left={'Journals'} right={<PageTitleRight />}>
            <div className="col-12">
                <div className="card">
                    <div className="card-body border-bottom py-3">
                        <div className="d-flex">
                            <div className="text-secondary">
                                Show
                                <div className="mx-2 d-inline-block">
                                    <input
                                        value={filters.show}
                                        onChange={(e) => setFilters({ ...filters, show: e.target.value })}
                                        type="text" className="form-control form-control-sm" size="3" aria-label="Invoices count" />
                                </div>
                                entries
                            </div>
                            <div className="ms-auto text-secondary">
                                Search:
                                <div className="ms-2 d-inline-block">
                                    <input
                                        onChange={(e) => setFilters({ ...filters, search: e.target.value })}
                                        value={filters.search}
                                        type="text" className="form-control form-control-sm" aria-label="Search invoice" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="table-responsive">
                        <table className="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Account Helper(Kode Bantu)</th>
                                    <th>Account Debit</th>
                                    <th>Account Credit</th>
                                    <th colSpan={2} className="w-1 text-center">
                                        Saldo
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    journals.data.map((journal, index) => (
                                        <tr key={index}>
                                            <td>{journal?.account?.code}</td>
                                            <td>{journal.date}</td>
                                            <td>{journal.description}</td>
                                            <td>
                                                {journal.account_helper?.name}
                                            </td>
                                            <td>{journal.type === 'D' ? journal.account?.name : ''}</td>
                                            <td>{journal.type === 'C' ? journal.account?.name : ''}</td>
                                            <td className="text-end">
                                                <NumericFormat
                                                    displayType="text"
                                                    thousandSeparator="."
                                                    decimalScale={2}
                                                    prefix="Rp. "
                                                    decimalSeparator=","
                                                    value={journal.type === 'D' ? journal.amount : 0}
                                                />
                                            </td>
                                            <td className="text-end">
                                                <NumericFormat
                                                    displayType="text"
                                                    thousandSeparator="."
                                                    decimalScale={2}
                                                    prefix="Rp. "
                                                    decimalSeparator=","
                                                    value={journal.type === 'C' ? journal.amount : 0}
                                                />
                                            </td>
                                            <td>
                                                <Link href={`/journals/${journal.transaction_id}/edit`}>
                                                    <span className="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" className="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
                                                    </span>
                                                </Link>
                                                <span className="text-secondary cursor-pointer" onClick={() => onDelete(journal.id)} >
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
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
                        <PaginateInfo from={journals.from} to={journals.to} total={journals.total} />
                        <Paginate links={journals.links} />
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default Index

const PageTitleRight = () => {
    return (
        <div className="col-auto ms-auto d-print-none">
            <div className="btn-list">
                <Link
                    href="/journals/create"
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
                    New Journal
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
