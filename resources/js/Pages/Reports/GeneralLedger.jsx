import React, { useState } from 'react'
import Layout from '../../Shared/Layout'
import { Link } from '@inertiajs/react'
import { NumericFormat } from 'react-number-format';
import Select from 'react-select';
import Button from '../../Shared/Button';
import { router } from '@inertiajs/react';
import { DatePicker } from 'rsuite';
import addDays from 'date-fns/addDays';
// Date Picker
import 'rsuite/dist/rsuite.min.css';

const GeneralLedger = ({ generalLedger, accounts, filters }) => {
    const [date, setDate] = useState(filters.to);

    const [selectedAccount, setSelectedAccount] = useState(filters.account_id);

    const handleFilter = () => {
        if (date && selectedAccount) {
            // date = date.toISOString().split('T')[0];
            router.visit(`/reports/general-ledger/${selectedAccount}?to=${date}&from=${date}`);
        }
    }

    const predefinedBottomRanges = [
        {
            label: 'Kemarin',
            value: addDays(new Date(), -1),
        },
        {
            label: 'Hari ini',
            value: new Date(),
        },
    ];

    return (
        <Layout left={'General Ledger (Buku Besar)'} right={<PageTitleRight />}>
            <div className="card">
                <div className="card-body border-bottom">
                    <div className="row">
                        <div className="col-md-2 form-group">
                            <label className="text-muted small mb-1">Filter Tanggal</label>
                            <div className="input-icon mb-2">
                                <div className="input-icon mb-2">
                                    <DatePicker
                                        onChange={(value) => {
                                            setDate(value);
                                        }}
                                        // value={new Date(date)}
                                        ranges={predefinedBottomRanges}
                                        placeholder="Pilih Tanggal"
                                        style={{ width: 300 }}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="col-md-3 form-group">
                            <label className="text-muted small" style={{ marginBottom: '2px' }}>Pilih Akun</label>
                            <Select
                                className="basic-single"
                                classNamePrefix="select"
                                defaultValue={{
                                    label: accounts.find((item) => item.id === selectedAccount)?.name ?? 'Pilih Akun',
                                    value: selectedAccount,
                                }}
                                options={accounts.map((item) => ({
                                    label: item.name + ' - ' + item.code,
                                    value: item.id,
                                }))}
                                onChange={(event) => {
                                    setSelectedAccount(event.value);
                                }}
                            />
                        </div>
                        <div className="col-md-3 form-group">
                            <label className="text-muted small" style={{ marginBottom: '12px' }}></label>
                            <div>
                                <Button type='primary' onClick={handleFilter}>
                                    Filter
                                </Button>
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
                                    <th>NO</th>
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

                                {generalLedger.map((item, index) => (
                                    <tr key={item.id}>
                                        <td>{index + 1}</td>
                                        <td>{item.date}</td>
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
