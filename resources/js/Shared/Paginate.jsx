import { Link } from '@inertiajs/react'
import React from 'react'

const Paginate = ({ links }) => {
    return (
        <ul className="pagination m-0 ms-auto">
            {
                links.map((link, index) => (
                    <li key={index} className={`page-item ${link.active ? 'active' : ''}`}>
                        <Link className="page-link" href={link.url}>
                            <span dangerouslySetInnerHTML={{ __html: link.label }} />
                        </Link>
                    </li>
                ))
            }
        </ul>
    )
}

export default Paginate

const PaginateInfo = ({ from, to,total, }) => {
    return (
        <p className="m-0 text-secondary">Showing <span>{from}</span> to <span>{to}</span> of <span>{total}</span> entries</p>
    )
}

export { PaginateInfo }
