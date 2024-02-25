import React, { useEffect, useRef, useState } from 'react'
import Layout from '../../Shared/Layout'
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch'
import InputDate from '../../Shared/InputDate'
import { toDayMonthYear, toIDR, toYearMonthDay } from '../../Shared/utils'
import { router } from '@inertiajs/react'

const AccountHelper = ({ accounts, journals }) => {
    const [filters, setFilters] = useState({
        end_date: new Date(),
        account_id: "",
    });

    const handleFilter = ({
        dateFilter,
        selectedAccountFilter,
    }) => {

        if (dateFilter && selectedAccountFilter) {
            const newDate = toYearMonthDay(dateFilter);
            router.get(
                `/reports/account-helper/${selectedAccountFilter}`,
                {
                    end_date: newDate,
                },
                { preserveState: true }
            );
        }
    }

    const firstRender = useRef(true);

    useEffect(() => {
        if (firstRender.current) {
            firstRender.current = false;
            return;
        }

        handleFilter({
            dateFilter: filters.to,
            selectedAccountFilter: filters.account_id,
        });
    }, [filters]);

    return (
        <Layout left={'Buku Besar'} right={<></>}>
            <div className="card">
                <div className="card-body border-bottom">
                    <div className="row">
                        <div className="col-md-3 form-group mb-2">
                            <InputSelectWithSearch
                                isRequired
                                label="Pilih Akun"
                                value={filters.account_id}
                                onChange={(value) => setFilters({ ...filters, account_id: value })}
                                options={accounts.map((item) => ({
                                    label: item.name + ' - ' + item.code,
                                    value: item.id,
                                }))}
                            />
                        </div>
                        <div className="col-md-3 form-group">
                            <div className="input-icon mb-2">
                                <InputDate
                                    format={'yyyy-MM-dd'}
                                    label="Tanggal"
                                    value={filters.to}
                                    onChange={(value) => setFilters({ ...filters, to: value })}
                                    isRequired
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="card mt-3">
                <div className="card-body border-bottom p-0">
                    <div className="table-responsive">
                        <table className="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                    {/* <th className="text-center">Aksi</th> */}
                                </tr>
                            </thead>
                            <tbody>
                                {journals.length === 0 && (
                                    <tr>
                                        <td colSpan={8} className="text-center">
                                            Data tidak ditemukan
                                        </td>
                                    </tr>
                                )}
                                {journals.map((item) => (
                                    <tr key={item.id}>
                                        <td>{toDayMonthYear(item.date)}</td>
                                        <td>{item.description}</td>
                                        <td>{toIDR(item.debit)}</td>
                                        <td>{toIDR(item.credit)}</td>
                                        <td>
                                            {toIDR(item.balance)}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </Layout>
    )
}

export default AccountHelper
