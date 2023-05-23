export default function Grid({ children, title }) {
    return (
        <div className="grid-container">
            <div className="grid-toolbar">
                <div className="grid-title">
                    <h2>{title}</h2>
                </div>

                <div className="grid-actions d-flex gap-3">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input
                            type="text"
                            id="gridSearchText"
                            class="form-control"
                            placeholder="Search"
                            aria-label="Search"
                            aria-describedby="Search items"
                        />
                    </div>
                    <a href="#" className="btn btn-primary">
                        Create
                    </a>
                </div>
            </div>
            <div className="card px-4 py-3">{children}</div>
        </div>
    );
}
