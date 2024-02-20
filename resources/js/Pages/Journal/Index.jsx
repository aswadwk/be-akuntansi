import React, { useState } from 'react'
import Paginate, { PaginateInfo } from '../../Shared/Paginate'
import Layout from '../../Shared/Layout'
import { Link } from '@inertiajs/react'
import { NumericFormat } from 'react-number-format';
import { toDayMonthYear } from '../../Shared/utils';
import { IconEdit } from '@tabler/icons-react';
import { IconTrash } from '@tabler/icons-react';

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
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Account</th>
                                    <th>Account Helper(Kode Bantu)</th>
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
                                            <td>{toDayMonthYear(journal.date)}</td>
                                            <td>{journal.description}</td>
                                            <td>
                                                {journal.account?.name}
                                                <br />
                                                <span className='text-secondary'>{journal?.account?.code}</span>
                                            </td>
                                            <td>
                                                {journal.account_helper?.name}
                                            </td>
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
                                                <div className='d-flex gap-2'>
                                                    <Link href={`/journals/${journal.transaction_id}/edit`}>
                                                        <IconEdit className='text-warning' size={18} />
                                                    </Link>
                                                    <span className="text-secondary cursor-pointer" onClick={() => onDelete(journal.id)} >
                                                        <IconTrash className='text-danger' size={18} />
                                                    </span>
                                                </div>
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
