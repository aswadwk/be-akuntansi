import React, { useState } from 'react'
import Layout from '../../../Shared/Layout'
import Input from '../../../Shared/Input'
import { useForm } from '@inertiajs/react'
import InputSelect from '../../../Shared/InputSelect'
import InputMultiSelectWithSearch from '../../../Shared/InputMultiSelectWithSearch'
import { IconEdit, IconTrash } from '@tabler/icons-react'
import axios from 'axios'

const randomId = () => {
    return Math.random().toString(36).substr(2, 9);
}

const initialData = {
    id: randomId(),
    title: "",
    section: 1,
    sub_title: "",
    type: "",
    accounts: [],
}

const ProfitLoss = ({ accounts, settings }) => {
    const [form, setForm] = useState(initialData)
    const [action, setAction] = useState('add')

    const { data, setData, post, errors, transform } = useForm(settings || [])

    const handleAdd = () => {
        if (action === 'add') {

            const newRows = [...data];

            newRows.push(form);

            setData(newRows)

            setForm({
                ...initialData,
                id: randomId(),
                section: form.section + 1
            })

            return
        }

        if (action === 'edit') {
            const newRows = data.map((item) => {
                if (item.id === form.id) {

                    return {
                        ...form,
                        accounts: form.accounts.map((account) => account),
                        section: parseInt(form.section),
                        sub_title: form.sub_title,
                        type: form.type,
                        title: form.title,
                    }
                }

                return item
            })

            setData(newRows)

            setForm(initialData)

            setAction('add')
        }
    }

    const handleDelete = (id) => {
        const newRows = data.filter((item) => item.id !== id)

        setData(newRows)
    }

    const handleEdit = (item) => {
        setAction('edit')
        setForm(item)
    }

    const onSubmit = (e) => {
        e.preventDefault()

        // console.log(data)
        // return

        axios.post("/setting-reports/profit-loss", {
            settings: data
        }).then((response) => {
            console.log(response)
        }).catch((error) => {
            console.log(error)
        }, {
            headers: {
                'Content-Type': 'application/json',
            }
        })


        // post("/setting-reports/profit-loss")
    }

    return (
        <Layout left={'Setting / Laba Rugi'} right={<></>}>
            <div className="col-12">
                <div className="card">
                    <div className="card-body">
                        <div className='row row-cards'>
                            <div className="col-sm-6 col-md-4">
                                <Input
                                    isRequired
                                    label="Section"
                                    placeholder="Section"
                                    onChange={e => setForm({ ...form, section: e.target.value })}
                                    value={form.section}
                                    type='number'
                                />
                            </div>
                            <div className="col-sm-6 col-md-4">
                                <Input
                                    isRequired
                                    label="Title"
                                    placeholder="Title"
                                    onChange={e => setForm({ ...form, title: e.target.value })}
                                    value={form.title}
                                />
                            </div>
                            <div className="col-sm-6 col-md-4">
                                <Input
                                    label="Sub Title"
                                    placeholder="Sub Title"
                                    onChange={e => setForm({ ...form, sub_title: e.target.value })}
                                    value={form.sub_title}
                                />
                            </div>
                            <div className="col-sm-6 col-md-4">
                                <InputSelect
                                    isRequired
                                    label="Type"
                                    options={[
                                        { value: "profit", label: "Profit" },
                                        { value: "loss", label: "Loss" },
                                    ]}
                                    onChange={e => setForm({ ...form, type: e.target.value })}
                                    value={form.type}
                                />
                            </div>
                            <div className="col-sm-6 col-md-8">
                                <InputMultiSelectWithSearch
                                    isRequired
                                    label="Accounts"
                                    options={
                                        accounts.map((account) => (
                                            { value: account.id, label: account.name }
                                        ))
                                    }
                                    onChange={e => setForm({ ...form, accounts: e })}
                                    value={form.accounts}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="card-footer text-end">
                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={() => handleAdd()}
                        >
                            {action === 'add' ? 'Tambah' : 'Update'}
                        </button>
                    </div>
                </div>

                <div className="card mt-3">
                    <div className="card-body p-0">
                        <div className="table-responsive">
                            <table className="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Nama Akun</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.sort((a, b) => a.section - b.section).
                                        map((item, index) => (
                                            <tr key={index}>
                                                <td colSpan={3} className='p-0 pb-4'>
                                                    <table className="table card-table table-vcenter text-nowrap datatable p-0 mb-3">
                                                        <thead>
                                                            <tr>
                                                                <th colSpan={3}>
                                                                    <div className='d-flex'>
                                                                        <h6>
                                                                            {item.title}
                                                                        </h6>
                                                                        <div className='d-flex gap-2'>
                                                                            <IconEdit
                                                                                className='ms-2 text-warning'
                                                                                onClick={() => { handleEdit(item) }}
                                                                            />
                                                                            <IconTrash
                                                                                className='ms-2 text-danger'
                                                                                onClick={() => { handleDelete(item.id) }}
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <table className="table card-table table-vcenter text-nowrap datatable p-0 mb-3">
                                                        <tbody>
                                                            {item.accounts.map((account, index) => (
                                                                <tr key={index}>
                                                                    <td>{
                                                                        accounts.find((acc) => acc.id === account)?.code
                                                                    }</td>
                                                                    <td>{
                                                                        accounts.find((acc) => acc.id === account)?.name
                                                                    }</td>
                                                                    <td>{0}</td>
                                                                </tr>
                                                            ))}
                                                        </tbody>
                                                    </table>
                                                    <table className="table card-table table-vcenter text-nowrap datatable p-0">
                                                        <thead>
                                                            <tr>
                                                                <th colSpan={3}>
                                                                    <h6>
                                                                        Total {item.title}
                                                                    </h6>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </td>
                                            </tr>
                                        ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div className="card-footer text-end">
                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={onSubmit}
                        >
                            Save
                        </button>
                    </div>
                </div>

                {/* <div className="card mt-3">
                    <div className="card-body">
                        <pre>
                            {JSON.stringify(data, null, 2)}
                        </pre>
                    </div>
                </div> */}
            </div>
        </Layout>
    )
}

export default ProfitLoss
