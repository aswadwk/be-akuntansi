import React, { useEffect, useRef, useState } from 'react'
import Layout from '../../Shared/Layout'
import { Link } from '@inertiajs/react'
import { NumericFormat } from 'react-number-format';
import { router } from '@inertiajs/react';
// Date Picker
import { toDayMonthYear, toYearMonthDay } from '../../Shared/utils';
import InputDate from '../../Shared/InputDate';
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch';

const GeneralLedger = ({ generalLedger, accounts }) => {
    const [filters, setFilters] = useState({
        to: new Date(),
        from: new Date(),
        account_id: "",
    });

    const handleFilter = ({
        dateFilter,
        selectedAccountFilter,
    }) => {

        if (dateFilter && selectedAccountFilter) {
            const newDate = toYearMonthDay(dateFilter);
            router.get(
                `/reports/general-ledger/${selectedAccountFilter}`,
                {
                    to: newDate,
                    from: newDate,
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
        <Layout left={'General Ledger (Buku Besar)'} right={<PageTitleRight />}>
            <div className="card">
                <div className="card-body border-bottom">
                    <div className="row">

                        <div className="col-md-3 form-group">
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
                <div className="card-body border-bottom py-3">
                    <div className="table-responsive">
                        <table className="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Akun</th>
                                    <th>Keterangan</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                    {/* <th className="text-center">Aksi</th> */}
                                </tr>
                            </thead>
                            <tbody>
                                {generalLedger.length === 0 && (
                                    <tr>
                                        <td colSpan={8} className="text-center">
                                            Data tidak ditemukan
                                        </td>
                                    </tr>
                                )}
                                {generalLedger.map((item) => (
                                    <tr key={item.id}>
                                        <td>{toDayMonthYear(item.date)}</td>
                                        <td>{item.name}</td>
                                        <td>{item.description}</td>
                                        <td>
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator="."
                                                decimalScale={0}
                                                prefix="Rp. "
                                                decimalSeparator=","
                                                value={item.debit}
                                            />
                                        </td>
                                        <td>
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator="."
                                                decimalScale={0}
                                                prefix="Rp. "
                                                decimalSeparator=","
                                                value={item.credit}
                                            />
                                        </td>
                                        <td>
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator="."
                                                decimalScale={0}
                                                prefix="Rp. "
                                                decimalSeparator=","
                                                value={item.balance}
                                            />
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="card-footer d-flex justify-content-between">
                        <p className="m-0 text-muted">
                            Showing <span>0</span> of
                            <span>0</span>
                            entries
                        </p>
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default GeneralLedger

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
