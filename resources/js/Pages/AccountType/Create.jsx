import React from 'react'
import Layout from '../../Shared/Layout'
import { useForm } from '@inertiajs/react'
import Input from '../../Shared/Input'
import InputSelect from '../../Shared/InputSelect'

const Create = () => {

    const { data, setData, post, errors, } = useForm({
        name: "",
        code: "",
        // position_normal: "",
        description: "",
    })

    const onSubmit = (e) => {
        e.preventDefault()
        post("/account-types")
    }

    return (
        <Layout left={"Account Type / Create"} right={<></>}>
            <div className="col-12 col-sm-6">
                <FormAddAccountType data={data} setData={setData} errors={errors} onSubmit={onSubmit} />
            </div>
        </Layout>
    )
}

export default Create


const FormAddAccountType = ({ onSubmit, data, errors, setData }) => {
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
                    {/* <div className="mb-3">
                        <InputSelect placeholder={"Posisi Normal"} options={[
                            { label: "Debit", value: "D" },
                            { label: "Credit", value: "C" },
                        ]}
                            onChange={e => setData("position_normal", e.target.value)}
                            value={data.position_normal}
                            error={errors.position_normal}
                            label={"Posisi Normal"}
                        />
                    </div> */}
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
