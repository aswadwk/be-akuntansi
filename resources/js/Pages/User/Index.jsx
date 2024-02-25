import React from 'react'
import Layout from '../../Shared/Layout'
import { IconPlus } from '@tabler/icons-react'
import Paginate, { PaginateInfo } from '../../Shared/Paginate'
import { Link } from '@inertiajs/react'
import { toYearMonthDayHourMinute } from '../../Shared/utils'
import { IconEdit } from '@tabler/icons-react'
import { IconTrash } from '@tabler/icons-react'

const Index = ({ users }) => {
    return (
        <Layout left={'Users'} right={<PageTitleRight />}>

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
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    users.data.map((user, index) => (
                                        <tr key={index}>
                                            <td>{user.name}</td>
                                            <td>{user.email}</td>
                                            <td>{user.roles.map((role, index) => (
                                                <span key={index} className="badge bg-secondary me-1">{role.name}</span>
                                            ))}</td>
                                            <td>{toYearMonthDayHourMinute(user.created_at)}</td>
                                            <td>
                                                <Link href={`/account-types/${user.id}/edit`}>
                                                    <span className="cursor-pointer text-warning">
                                                        <IconEdit size={18} />
                                                    </span>
                                                </Link>
                                                <button
                                                    className="text-secondary cursor-pointer bg-transparent"
                                                    onClick={() => onDelete(user.id)} >
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
                        <PaginateInfo from={users.from} to={users.to} total={users.total} />
                        <Paginate links={users.links} />
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
                    href="/setting-users/create"
                    className="btn btn-primary d-none d-sm-inline-block"
                >
                    <IconPlus />
                    Add User
                </Link>
                <Link
                    href="/setting-users/create"
                    className="btn btn-primary d-sm-none btn-icon"
                >
                    <IconPlus />
                </Link>
            </div>
        </div>
    )
}
