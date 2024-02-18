import React from 'react'
import Layout from '../../Shared/Layout'
import { Link, useForm } from '@inertiajs/react'
import { IconPlus } from '@tabler/icons-react'
import { dateHumanize, toYearMonthDayHourMinute } from '../../Shared/utils'
import Paginate, { PaginateInfo } from '../../Shared/Paginate'
import { IconEdit, IconTrash } from '@tabler/icons-react'

const Index = ({ accountHelpers }) => {
    const { delete: destroy } = useForm({});

    const onDelete = (accountTypeId) => {
        if (confirm('Are you sure you want to delete this account type?')) {
            // Delete it!
            destroy(`/account-helpers/${accountTypeId}`)
        }
    }

    return (
        <Layout left={'Account Helpers(Kode Bantu)'} right={<PageTitleRight />}>
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
                                    <th>Account Type</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    accountHelpers.data.map((accountType, index) => (
                                        <tr key={index}>
                                            <td>{accountType.name}</td>
                                            <td>{accountType.code}</td>
                                            <td>
                                                <span className='text-capitalize'>
                                                    {accountType.account_type}
                                                </span>
                                            </td>
                                            <td>{accountType.position_normal === "D" ? 'Debit' : 'Credit'}</td>
                                            <td>{accountType.description}</td>
                                            <td>{toYearMonthDayHourMinute(accountType.created_at)}
                                                <br />
                                                <span className="text-secondary">{dateHumanize(accountType.created_at)}</span>
                                            </td>
                                            <td>
                                                <Link href={`/account-helpers/${accountType.id}/edit`}>
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
                        <PaginateInfo from={accountHelpers.from} to={accountHelpers.to} total={accountHelpers.total} />
                        <Paginate links={accountHelpers.links} />
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
                    href="/account-helpers/create"
                    className="btn btn-primary d-none d-sm-inline-block"
                >
                    <IconPlus />
                    Add Account Type
                </Link>
                <Link
                    href="/account-helpers/create"
                    className="btn btn-primary d-sm-none btn-icon"
                >
                    <IconPlus />
                </Link>
            </div>
        </div>
    )
}
