import React from 'react'
import Layout from '../../Shared/Layout'
import { useForm } from '@inertiajs/react'
import Input from '../../Shared/Input'

const Create = ({ accountTypes }) => {

    const { data, setData, post, errors, } = useForm({
        name: "",
        code: "",
        position_normal: "",
        account_type_id: "",
        description: "",
    })

    const onSubmit = (e) => {
        e.preventDefault()
        post("/accounts")
    }

    return (
        <Layout left={"Account / Create"} right={<></>}>
            <div className="col-12 col-sm-6">
                <FormAddAccountType accountTypes={accountTypes} data={data} setData={setData} errors={errors} onSubmit={onSubmit} />
            </div>
        </Layout>
    )
}

export default Create


const FormAddAccountType = ({ onSubmit, data, errors, setData, accountTypes }) => {
    const submit = (e) => {
        e.preventDefault()
        onSubmit(data)
    }

    return (
        <form onSubmit={submit}>
            <div className="card">
                <div className="card-body">
                    <div className="mb-3">
                        <Input
                            label="Nama Akun"
                            placeholder="Nama"
                            onChange={e => setData("name", e.target.value)}
                            error={errors.name}
                            value={data.name}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            label="Kode Akun"
                            placeholder="Kode"
                            onChange={e => setData("code", e.target.value)}
                            error={errors.code}
                            value={data.code}
                        />
                    </div>
                    <div className="mb-3">
                        <label className="form-label">Posisi Normal</label>
                        <select
                            onChange={e => setData("position_normal", e.target.value)}
                            value={data.position_normal}
                            className="form-select"
                            placeholder="Pilih posisi normal"
                        >
                            <option value="">Pilih Posisi Normal</option>
                            <option value="D">Debet</option>
                            <option value="C">Kredit</option>
                        </select>
                    </div>
                    <div className="mb-3">
                        <label className="form-label">Account Type</label>
                        <select
                            onChange={e => setData("account_type_id", e.target.value)}
                            value={data.account_type_id}
                            className={`form-select ${errors.account_type_id ? 'is-invalid' : ''}`}
                            placeholder="Pilih posisi normal"
                        >
                            <option value="">Choose Posisi Normal</option>
                            {accountTypes.map((item, index) => (
                                <option key={index} value={item.id}>{item.name}</option>
                            ))}
                        </select>
                        {errors.account_type_id && <div className="invalid-feedback">{errors.account_type_id}</div>}
                    </div>
                    <div className="mb-3">
                        <Input
                            label="Description"
                            placeholder="Description"
                            onChange={e => setData("description", e.target.value)}
                            error={errors.description}
                            value={data.description}
                        />
                    </div>
                </div>
                <div className="card-footer text-end">
                    <button className='btn btn-primary' onClick={onSubmit}>Save</button>
                </div>
            </div>
        </form>
    )
}
