
import { useForm } from '@inertiajs/react';
import React from 'react'
import { NumericFormat } from 'react-number-format';
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch';
import InputDate from '../../Shared/InputDate';
import InputNumber from '../../Shared/InputNumber';
import { toYearMonthDay } from '../../Shared/utils';
import InputSelect from '../../Shared/InputSelect';

const Edit = ({ accounts, journals, accountHelpers }) => {
    const { data, setData, put, transform, errors, processing } = useForm({
        date: new Date(journals.created_at),
        status: journals.status,
        description: journals.journals[0].description || '',
        account_helper_id: journals.journals[0].account_helper_id,
        journals: journals.journals.map((row) => ({
            amount: row.amount,
            type: row.type,
            account_id: row.account_id,
        })),
    });

    function sumArray(array) {
        let sum = 0;
        for (const value of array) {
            sum += value;
        }
        return sum;
    }

    function filterType(journals, type) {
        return sumArray(
            journals
                .filter((row) => row.type === type)
                .map((row) => Number(row.amount.toString().replace('Rp. ', '').replaceAll(',', ''))),
        );
    }

    function handleReset() {
        window.location.reload();
    }

    const addRow = () => {
        const newRow = [...data.journals];
        newRow.push({
            amount: '',
            type: '',
            account_id: '',
        });

        setData({ ...data, journals: newRow });
    };

    const deleteRow = (index) => {
        if (data.journals.length === 2) {
            alert('Minimal 2 baris');

            return;
        }

        const newRow = [...data.journals];
        newRow.splice(index, 1);

        setData({ ...data, journals: newRow });
    };

    function handleChangeAmount(value, index, type) {
        setData({
            ...data,
            journals: data.journals.map((row, i) => {
                if (i === index) {
                    return {
                        ...row,
                        amount: value,
                        type: type,
                    };
                }
                return row;
            }),
        });
    }

    async function handleSubmit(event) {
        event.preventDefault();

        transform((data) => ({
            ...data,
            date: toYearMonthDay(data.date),
            journals: data.journals.map((row) => ({
                ...row,
                amount: row.amount.toString().replace('Rp. ', '').replaceAll(',', ''),
            })),
        }));

        put(`/journals/${journals.id}`);
    }

    return (
        <div className="col-12">
            <div className="card">
                <form onSubmit={handleSubmit}>
                    <div className="card-header">
                        <h3 className="card-title">Form Update Jurnal</h3>
                    </div>
                    <div className="card-body">
                        <div className="row row-cards">
                            <div className="mb-3 col-sm-4 col-md-2">
                                <InputDate
                                    format={'yyyy-MM-dd'}
                                    label="Tanggal"
                                    value={data.date}
                                    onChange={(value) => setData({ ...data, date: value })}
                                    error={errors.date}
                                    isRequired
                                />
                            </div>
                            <div className="mb-3 col-sm-6 col-md-2">
                                <InputSelect
                                    isRequired
                                    label="Status"
                                    placeholder={'Pilih Status'}
                                    options={[
                                        { label: 'Approve', value: "APPROVED" },
                                        { label: 'Draft', value: "DRAFT" },
                                    ]}
                                    value={data.status}
                                    onChange={(event) => {
                                        setData({ ...data, status: event.target.value });
                                    }}
                                    error={errors.status}
                                />
                            </div>
                            <div className="mb-3 col-sm-6 col-md-4">
                                <InputSelectWithSearch
                                    label="Kode Bantu"
                                    placeholder={'Pilih Kode Bantu'}
                                    options={accountHelpers.map((item) => ({
                                        label: item.name + ' - ' + item.code,
                                        value: item.id,
                                    }))}
                                    value={data.account_helper_id}
                                    onChange={(value) => {
                                        setData({ ...data, account_helper_id: value });
                                    }}
                                    error={errors.account_helper_id}
                                />
                            </div>
                        </div>
                        <div className="mb-3">
                            <label className="form-label">Keterangan</label>
                            <textarea
                                placeholder="Masukkan keterangan"
                                className="form-control"
                                rows={2}
                                onChange={(event) => setData({ ...data, description: event.target.value })}
                                value={data.description}
                            >
                                {data.description}
                            </textarea>
                        </div>
                        <div className="table-responsive" style={{ overflowX: 'unset' }}>
                            <table className="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th className="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.journals.map((journal, index) => (
                                        <tr key={index}>
                                            <td>
                                                <InputSelectWithSearch
                                                    options={accounts.map((item) => ({
                                                        label: item.name + ' - ' + item.code,
                                                        value: item.id,
                                                    }))}
                                                    onChange={(value) => {
                                                        setData({
                                                            ...data,
                                                            journals: data.journals.map((row, i) => {
                                                                if (i === index) {
                                                                    return {
                                                                        ...row,
                                                                        account_id: value,
                                                                    };
                                                                }
                                                                return row;
                                                            }),
                                                        });
                                                    }}
                                                    value={journal.account_id}
                                                    error={`${errors['journals.' + index + '.account_id'] || ''}`}
                                                />
                                            </td>
                                            <td>
                                                <InputNumber
                                                    style={{ textAlign: 'right' }}
                                                    borderError={false}
                                                    value={journal.type === 'D' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event.target.value, index, 'D')}
                                                    error={`${errors['journals.' + index + '.amount'] || ''}`}
                                                    prefix={'Rp. '}
                                                />
                                            </td>
                                            <td>
                                                <InputNumber
                                                    style={{ textAlign: 'right' }}
                                                    borderError={false}
                                                    value={journal.type === 'C' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event.target.value, index, 'C')}
                                                    error={`${errors['journals.' + index + '.amount'] || ''}`}
                                                    prefix={'Rp. '}
                                                />
                                            </td>
                                            <td>
                                                <button
                                                    className="btn btn-outline-danger"
                                                    onClick={() => deleteRow(index)}
                                                    type="button"
                                                >
                                                    -
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <button
                                                className="btn btn-outline-primary"
                                                onClick={() => addRow()}
                                                type="button"
                                            >
                                                Tambah
                                            </button>
                                        </td>
                                        <td className="text-end me-12">
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator=","
                                                decimalScale={2}
                                                prefix="Rp. "
                                                decimalSeparator="."
                                                value={filterType(data.journals, 'D')}
                                            />
                                        </td>
                                        <td className="text-end me-2">
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator=","
                                                decimalScale={2}
                                                prefix="Rp. "
                                                decimalSeparator="."
                                                value={filterType(data.journals, 'C')}
                                            />
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div className="card-footer text-end">
                        <div className='d-flex justify-content-between'>
                            <button type="button" onClick={
                                () => {
                                    window.history.back();
                                }
                            } className="btn btn-outline-secondary">
                                Cancel
                            </button>
                            <div className="d-flex gap-2 justify-content-end">
                                <button type="button" onClick={handleReset} className="btn btn-outline-warning">
                                    Reset
                                </button>
                                {filterType(data.journals, 'D') === filterType(data.journals, 'C') ? (
                                    <button className="btn btn-primary gap-2" type="submit">
                                        {processing && (
                                            <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true" />
                                        )}
                                        Simpan
                                    </button>
                                ) : (
                                    <button className="btn btn-primary" disabled type='button'>
                                        Simpan
                                    </button>
                                )}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default Edit
