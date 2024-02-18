import React from 'react'
import Select from 'react-select';
import { NumericFormat } from 'react-number-format';
import { useForm } from '@inertiajs/react';
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch';
import InputDate from '../../Shared/InputDate';
import { toYearMonthDay } from '../../Shared/utils';
import InputNumber from '../../Shared/InputNumber';

const Create = ({ accounts, accountHelpers }) => {
    const [isLoading, setIsLoading] = React.useState(false);
    const { data, setData, post, transform, errors } = useForm({
        date: null,
        description: '',
        account_helper_id: '',
        journals: [
            {
                amount: '',
                type: '',
                account_id: '',
            },
            {
                amount: '',
                type: '',
                account_id: '',
            },
        ],
    })

    console.log(errors);

    // {
    //     "date": "The date field must be a date before or equal to today.",
    //     "journals.0.amount": "The journals.0.amount field is required.",
    //     "journals.1.amount": "The journals.1.amount field is required.",
    //     "journals.0.account_id": "The journals.0.account_id field is required.",
    //     "journals.1.account_id": "The journals.1.account_id field is required.",
    //     "journals.0.type": "The journals.0.type field is required.",
    //     "journals.1.type": "The journals.1.type field is required."
    // }
    // log errors jurnals


    // errors.journals.0.amount
    console.log('errors.journals.0.amount', errors['journals.0.amount']);

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
        console.log(newRow);
        newRow.push({
            amount: '',
            type: '',
            account_id: '',
        });

        console.log(newRow);

        setData({ ...data, journals: newRow });
    };

    const deleteRow = (index) => {
        if (data.journals.length === 2) {
            alert('Minimal 2 baris');
        }

        const newRow = [...data.journals];
        newRow.splice(index, 1);

        setData({ ...data, journals: newRow });
    };

    function handleChangeAmount(value, index, type) {
        // console.log(value.target.value, index, type);
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

        setIsLoading(true);

        transform((data) => ({
            ...data,
            date: toYearMonthDay(data.date),
            journals: data.journals.map((row) => ({
                ...row,
                amount: row.amount.toString().replace('Rp. ', '').replaceAll(',', ''),
            })),
        }));

        post('/journals', {
            preserveScroll: true,
            onSuccess: () => {
                setIsLoading(false);
            },
            onError: () => {
                setIsLoading(false);
            }
        });
    }

    return (
        <div className="col-12">
            <div className="card">
                <form onSubmit={handleSubmit}>
                    <div className="card-header">
                        <h3 className="card-title">Form Tambah Jurnal</h3>
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
                                                    borderError={false}
                                                    value={journal.type === 'D' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event.target.value, index, 'D')}
                                                    error={`${errors['journals.' + index + '.amount'] || ''}`}
                                                    prefix={'Rp. '}
                                                />
                                            </td>
                                            <td>
                                                <InputNumber
                                                    borderError={false}
                                                    value={journal.type === 'C' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event.target.value, index, 'C')}
                                                    error={`${errors['journals.' + index + '.amount'] || ''}`}
                                                    prefix={'Rp. '}
                                                />
                                            </td>
                                            <td>
                                                <button className="btn btn-outline-danger" onClick={() => deleteRow(index)}>
                                                    -
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <button className="btn btn-outline-primary" onClick={addRow}>
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
                        <div className="d-flex gap-2 justify-content-end">
                            <button type="button" onClick={handleReset} className="btn btn-outline-secondary">
                                Reset
                            </button>
                            {filterType(data.journals, 'D') === filterType(data.journals, 'C') ? (
                                <button className="btn btn-primary gap-2" type="submit">
                                    {isLoading && (
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
                </form>
            </div>
        </div>
    )
}

export default Create
